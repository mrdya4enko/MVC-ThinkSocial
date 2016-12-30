<?php
namespace App\Controllers   ;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

abstract class ControllerBase
{
    private $modelsNameSpace;
    private $db;
    protected $modelsAction;
    protected $modelsPool = array();
    protected $templateInfo = array('templateNames' => array(), 'title' => '');

    public function __construct($modelsNameSpace, $db, $modelsAction)
    {
        $this->db = $db;
        $this->modelsNameSpace = $modelsNameSpace;
        $this->modelsAction = $modelsAction;
        $this->setModelsPool();
        $this->setTemplateNames();
        $this->setTitle();
    }
    protected abstract function setModelsPool();
    protected abstract function setTemplateNames();
    protected abstract function setTitle();
    protected abstract function setControllerVars($args);
    public function getTemplateInfo($args)
    {
        if (isset($_POST)) {
            $responseArgs = array_merge($args, $_POST);
        } else {
            $responseArgs = $args;
        }
        foreach ($this->modelsPool as $modelName => $modelAction) {
            $modelClassName = $this->modelsNameSpace . $modelName;
            $model = new $modelClassName($modelAction, $this->db);
            $responseVars = $model->getResponse($responseArgs);
            if (is_array($responseVars)) {
                $this->templateInfo = array_merge($this->templateInfo, $responseVars);
            }
        }
        $this->templateInfo = array_merge($this->templateInfo, $args);
        $this->setControllerVars($args);
        return $this->templateInfo;
    }
}
