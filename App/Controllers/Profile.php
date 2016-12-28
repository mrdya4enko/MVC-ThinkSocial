<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

Class Profile Extends ControllerBase
{
    protected function setModelsPool()
    {
        if ($this->modelsAction == 'update') {
            $this->modelsPool = array ('User' => 'update');
        } else {
            $this->modelsPool = array ('User' => 'select',
                'UserAvatar' => 'select',
                'Cities' => 'select',
                'Groups' => 'select',
                'Albums' => 'select',
                'Phones' => 'select',
                'FriendRequests' => 'select',
                'Notifications' => 'select');
        }
    }
    protected function setTemplateNames()
    {
        $this->templateInfo['templateNames'] = array('head', 'navbar', 'leftcolumn', 'middleprofile', 'rightcolumn', 'footer');
    }
    protected function setTitle()
    {
        switch ($this->modelsAction) {
            case "show":
                $this->templateInfo['title'] = 'Профиль';
                break;
            case "edit":
                $this->templateInfo['title'] = 'Редактирование профиля';
                break;
        }
    }
    protected function setControllerVars($args)
    {
        switch ($this->modelsAction) {
            case "show":
                $this->templateInfo['submitAction']='edit';
                $this->templateInfo['submitValue']='Редактировать';
                $this->templateInfo['allowEdit']='disabled';
                break;
            case "edit":
                $this->templateInfo['submitAction']='update';
                $this->templateInfo['submitValue']='Подтвердить';
                $this->templateInfo['allowEdit']='enabled';
                break;
            case "update":
                header('Location: http://ts.local/?r=profile/show&' . http_build_query($args));
                break;
        }
    }
}
