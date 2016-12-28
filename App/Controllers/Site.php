<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

Class Site Extends ControllerBase
{
    protected function setModelsPool()
    {
        $this->modelsPool = array ('User' => 'select',
            'UserAvatar' => 'select',
            'Cities' => 'select',
            'Groups' => 'select',
            'Albums' => 'select',
            'News' => 'select',
            'FriendRequests' => 'select',
            'Notifications' => 'select');
    }
    protected function setTemplateNames()
    {
        $this->templateInfo['templateNames'] = array('head', 'navbar', 'leftcolumn', 'middlecolumn', 'rightcolumn', 'footer');
    }
    protected function setTitle()
    {
        $this->templateInfo['title'] = 'ThinkSocial';
    }
    protected function setControllerVars($args)
    {
    }
}
