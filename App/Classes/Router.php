<?php
namespace App\Classes;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 12:28
 */

class Router
{
    private $controlNameSpace;
    public $controllerFile;
    public $controllerName;
    public $controllerAction;
    public $controllerArgs = array();

    public function __construct($nameSpace)
    {
        $this->controlNameSpace = $nameSpace;
    }

    public function getController($modelsNameSpace, $db)
    {
        $controller = array ('ref' => '',
                             'action' => '',
                             'args' => '');
        $acceptedRoutes = include SITE_PATH . 'App/Includes/routes.php';
        $route = isset($_GET['r'])? strtolower(trim($_GET['r'], "/")) : 'site/index';

        $controllerNameAction = isset($acceptedRoutes[$route])? $acceptedRoutes[$route] :
            array("controller" => "Site", "action" => "Index");

        $controller['args'] = isset($_GET['r'])? array_diff($_GET, array($_GET['r'])):$_GET;

        $controlClassName = $this->controlNameSpace . $controllerNameAction['controller'];
        $controller['action'] = $controllerNameAction['action'];
        $controller['ref'] = new $controlClassName($modelsNameSpace, $db, $controller['action']);

        return $controller;
    }
}
