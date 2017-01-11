<?php
namespace App\Controllers   ;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

abstract class BaseController
{
    protected $templateInfo = ['templateNames' => [],
                               'title' => ''];
    protected $modelsAction;
    protected $args;

    protected abstract function getTemplateNames();
    protected abstract function getTitle();
    protected abstract function getControllerVars();
    public function index($modelsAction, $args)
    {
        $this->modelsAction = $modelsAction;
        $this->args = $args;

        $this->getTemplateNames();
        $this->getTitle();
        $this->templateInfo = array_merge($this->templateInfo, $this->args);
        if (is_array($this->getControllerVars())) {
            $this->templateInfo = array_merge($this->templateInfo, $this->getControllerVars());
        }
        return $this->templateInfo;
    }
}
