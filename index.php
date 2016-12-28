<?php
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 10:52
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Константы:
define('SITE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

require_once 'App/Includes/autoload.php';

// register the base directories for the namespace prefix
$loader = new Psr4AutoloaderClass;
$loader->register();
$loader->addNamespace('App', './App');

$application1 = \App\Classes\Application::getInstance();
$application1 -> run();