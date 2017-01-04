<?php
namespace App\Classes;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 13.12.16
 * Time: 14:52
 */

class Application
{
    private $config;
    private $db;
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
        $this->config = include SITE_PATH . 'App/Includes/config.php';
    }
    private function setDB()
    {
        $connectStr = "{$this->config['connection']}:host={$this->config['host']};" .
                      "dbname={$this->config['dbName']}";
        $this->db = new \PDO($connectStr, $this->config['user'], $this->config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->db->exec('SET NAMES "utf8"');
        $_ENV['db'] = $this->db;
    }
    private function setRouter()
    {
        $this->router = new Router("App\\" . $this->config['controllersPath'] . "\\");
    }
    private function initialize ()
    {
        $this->setConfig();
        $this->setDB();
        $this->setRouter();
    }
    private function doProcess ()
    {
        $this->templateInfo = $this->controller['ref']->index();
    }
    private function process ()
    {
        $this->controller = $this->router->getController("App\\" .  $this->config['modelsPath'] . "\\");
        $this->doProcess();
    }
    private function setTemplate()
    {
        $this->template = new Template($this->templateInfo);
    }
    private function render ()
    {
        $this->setTemplate();
        $this->template->show("App/" . $this->config['templatesPath']);
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
