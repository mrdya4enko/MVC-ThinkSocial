<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

abstract class ModelQuery extends ModelBase
{
    private $db;
    protected $query;
    protected $queryResult;
    protected $queryParams = array("select" => array("string" => "", "params" => array()),
        "insert" => array("string" => "", "params" => array()),
        "update" => array("string" => "", "params" => array()),
        "delete" => array("string" => "", "params" => array()));

    protected abstract function setQueryParams();
    public function __construct($action, $db)
    {
        $this->action = $action;
        $this->db = $db;
        $this->setQueryParams();
    }
    protected function exec($args)
    {
        $queryString = $this->queryParams[$this->action]["string"];
        $queryParams = $this->queryParams[$this->action]["params"];
        $this->query = $this->db->prepare($queryString);
        foreach ($args as $param => $value) {
            if (isset($queryParams[$param])) {
                $queryParams[$param] = $value;
            }
        }
        $this->query->execute($queryParams);
        if ($this->action == "select") {
            $this->queryResult = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}
