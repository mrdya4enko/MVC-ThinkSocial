<?php
namespace App\Components;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 13.12.16
 * Time: 14:52
 */

class Application
{
    private $config;
    private $router;
    private $templateInfo;
    private $template;
    private $controller;
    private static $instance;

    private function __construct()
    {
    }
    public static function getInstance()
    {
        if (empty (self::$instance)) {
            self::$instance = new Application();
        }
        return self::$instance;
    }
    private function setConfig()
    {
        $this->config = include ROOT . '/App/Config/config.php';
    }
    private function setRouter()
    {
        $this->router = new Router('App\\' . $this->config['controlNameSpace'] . '\\');
    }
    private function initialize ()
    {
        $this->setConfig();
        $this->setRouter();
    }
    private function doProcess ()
    {
        if (is_callable([$this->controller['ref'], $this->controller['actionName']])) {
            $this->templateInfo = call_user_func_array([$this->controller['ref'], $this->controller['actionName']], $this->controller['args']);
        } else {
            $this->templateInfo = $this->controller['ref']->index($this->controller['actionName'], $this->controller['args']);
        }
    }
    private function process ()
    {
        $this->controller = $this->router->run();
        $this->doProcess();
    }
    private function setTemplate()
    {
        $this->template = new Template($this->templateInfo);
    }
    private function render ()
    {
        $this->setTemplate();
        $this->template->show($this->config['templatesPath']);
    }
    private function finish ()
    {

    }
    public function run()
    {
        $this->initialize();
        $this->process();
        $this->render();
        $this->finish();
    }
}
