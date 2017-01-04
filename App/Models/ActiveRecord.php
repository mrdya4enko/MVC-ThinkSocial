<?php
namespace App\Models;
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

    private static function setDB()
    {
        self::$db = $_ENV['db'];
    }
    public static function getByID($id)
    {
        self::$queryString = "SELECT * FROM " . static::$tableName . " WHERE id=:id";
        $result = self::execSQL(array('id' => $id), 'select');
/*        if (count($result) == 0) {
            throw new idNotExistsException ("Задано несуществующее значение первичного ключа");
        } elseif (count($result) > 1) {
            throw new idNotUniqueException ("Не уникальное значение первичного ключа");
        }*/
        return ($result)[0];
    }
    public static function getByForeign($foreignKey, $addCondition)
    {
        self::$queryString = "SELECT * FROM " . static::$tableName . " WHERE ";
        foreach ($foreignKey as $key => $value) {
            self::$queryString .= "$key=:$key";
        }
        self::$queryString .= $addCondition;
        return self::execSQL($foreignKey, 'select');
    }
    public function update()
    {
        self::$queryString = "UPDATE " . static::$tableName . " SET ";
        $first = true;
        foreach (get_object_vars($this) as $key => $value) {
            if (! in_array($key, array ('id'))) {
                if (!$first) {
                    $space = ", ";
                } else {
                    $space = "";
                    $first = false;
                }
                self::$queryString .= $space . "$key=:$key";
            }
        }
        self::$queryString .= " WHERE id=:id";
        self::execSQL(get_object_vars($this), 'update');
    }
    public function insert()
    {
        self::$queryString = "INSERT INTO " . static::$tableName;
        $first = true;
        $columns="";
        $params="";
        foreach (get_object_vars($this) as $key => $value) {
            if (! in_array($key, array ('id'))) {
                if (!$first) {
                    $space = ", ";
                } else {
                    $space = "";
                    $first = false;
                }
                $columns .= $space . $key;
                $params .= $space . ":$key";
            }
        }
        self::$queryString .= " ($columns) VALUES ($params)";
        self::execSQL(get_object_vars($this), 'insert');
    }
    public static function count($foreignKey, $addCondition)
    {
        self::$queryString = "SELECT COUNT(*) AS count FROM " . static::$tableName . " WHERE ";
        foreach ($foreignKey as $key => $value) {
            self::$queryString .= "$key=:$key";
        }
        self::$queryString .= $addCondition;
        return (self::execSQL($foreignKey, 'select'))[0]->count;
    }
    protected static function execSQL($queryParams, $action)
    {
        self::setDB();
        $className = get_called_class();
        $query = self::$db->prepare(self::$queryString);
        $query->execute($queryParams);
        if ($action == 'update' || $action == 'insert') {
            return;
        }
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);
        $result = array();
        foreach ($rows as $row) {
            $object = new $className();
            foreach ($row as $field => $value) {
                $object->{$field} = $value;
            }
            array_push($result, $object);
        }
        return $result;
    }
}
