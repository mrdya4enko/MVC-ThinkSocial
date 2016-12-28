<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

abstract class ModelBase
{
    protected $responseVars = array();
    protected $action;

    public function __construct($action, $db)
    {
        $this->action = $action;
    }
    protected abstract function exec($args);
    protected abstract function convertOutput();
    public function getResponse($args)
    {
        $this->exec($args);
        $this->convertOutput();
        return $this->responseVars;
    }
}
