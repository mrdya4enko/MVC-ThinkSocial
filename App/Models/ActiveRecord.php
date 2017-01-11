<?php
namespace App\Models;
use App\Config\Db;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

abstract class ActiveRecord
{
    private static $db;
    protected static $tableName;
    private static $queryString;
    protected static $joinedModel = [];
    protected static $tableFields = [];

    private static function setDB()
    {
        self::$db = Db::getConnection();
    }

    private static function getFieldsSelect()
    {
        $pieces = [];
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            array_push($pieces, static::$tableName.".$fieldDB AS $fieldObject");
        }
        return implode(", ", $pieces);
    }

    private function getFieldsUpdate()
    {
        $pieces = [];
        $fields = get_object_vars($this);
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            if (isset($fields[$fieldObject]) && $fieldDB != "id") {
                array_push($pieces, "$fieldDB=:$fieldObject");
            }
        }
        return implode(", ", $pieces);
    }

    private function getFieldsInsert()
    {
        $piecesColumns = [];
        $piecesParams = [];
        $fields = get_object_vars($this);
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            if (isset($fields[$fieldObject]) && $fieldDB != "id") {
                array_push($piecesColumns, $fieldDB);
                array_push($piecesParams, ":$fieldObject");
            }
        }
        return [implode(", ", $piecesColumns), implode(", ", $piecesParams)];
    }

    private static function getDBCondition($condition)
    {
        $pieces = [];
        foreach (static::$tableFields as $fieldDB => $fieldObject) {
            if (isset($condition[$fieldObject])) {
                array_push($pieces, "$fieldDB=:$fieldObject");
            }
        }
        return implode(" AND ", $pieces);
    }

    private static function execSQL($queryParams, $action)
    {
        self::setDB();
        $className = get_called_class();
        $query = self::$db->prepare(self::$queryString);
        $queryResult = $query->execute($queryParams);
        if ($queryResult && $action == 'insert') {
            return (self::$db)->lastInsertId();
        }
        if ($action == 'update' || $action == 'delete') {
            return;
        }
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $object = new $className();
            foreach ($row as $field => $value) {
                $object->{$field} = $value;
            }
            array_push($result, $object);
        }
        return $result;
    }

    private static function getJoin($rows)
    {
        $className = get_called_class();
        if (isset(self::$joinedModel[$className])) {
            $thisKey = self::$joinedModel[$className]["thisKey"];
            $joinedName = self::$joinedModel[$className]["joinedName"];
            $joinedNameShort = substr($joinedName, strrpos($joinedName, '\\') + 1);
            $joinedKey = self::$joinedModel[$className]["joinedKey"];
            $addCondition = self::$joinedModel[$className]["addCondition"];
            foreach ($rows as $row) {
                if ($joinedKey=='id') {
                    $value = $joinedName::getByID($row->{$thisKey});
                } else {
                    $value = $joinedName::getByCondition([$joinedKey => $row->{$thisKey}], $addCondition);
                }
                $row->{lcfirst($joinedNameShort)} = $value;
            }
        }
        return $rows;
    }

    public static function join($thisModelKey, $joinedModelName, $joinedModelKey, $addCondition="")
    {
        $className = get_called_class();
        self::$joinedModel[$className] = ["thisKey" => $thisModelKey,
            "joinedName" => $joinedModelName,
            "joinedKey" => $joinedModelKey,
            "addCondition" => $addCondition,
        ];
    }

    public static function clearJoins()
    {
        self::$joinedModel = [];
    }

    public static function getByID($id)
    {
        $fields = self::getFieldsSelect();
        self::$queryString = "SELECT $fields FROM " . static::$tableName . " WHERE id=:id";
        $result = self::execSQL(['id' => $id], 'select');
        return (self::getJoin($result))[0];
    }

    public static function getByCondition($condition, $addCondition="")
    {
        $fields = self::getFieldsSelect();
        $conditionString = self::getDBCondition($condition);
        self::$queryString = "SELECT $fields FROM " . static::$tableName . " WHERE $conditionString $addCondition";

        $result = self::execSQL($condition, 'select');
        return self::getJoin($result);
    }

    public static function deleteSoft($id)
    {
        self::$queryString = "UPDATE " . static::$tableName . " SET deleted=1 WHERE id=:id";
        self::execSQL(['id' => $id], 'update');
    }

    public static function delete($id)
    {
        self::$queryString = "DELETE FROM " . static::$tableName . " WHERE id=:id";
        self::execSQL(['id' => $id], 'delete');
    }

    public function update()
    {
        $fields = self::getFieldsUpdate();
        self::$queryString = "UPDATE " . static::$tableName . " SET $fields  WHERE id=:id";
        self::execSQL(get_object_vars($this), 'update');
    }

    public function insert()
    {
        list ($columns, $params) = self::getFieldsInsert();
        self::$queryString = "INSERT INTO " . static::$tableName . " ($columns) VALUES ($params)";
        $this->id = self::execSQL(get_object_vars($this), 'insert');
    }

    public static function count($condition, $addCondition="")
    {
        $conditionString = self::getDBCondition($condition);
        self::$queryString = "SELECT COUNT(*) AS count FROM " . static::$tableName . " WHERE $conditionString $addCondition";
        return (self::execSQL($condition, 'select'))[0]->count;
    }
}
