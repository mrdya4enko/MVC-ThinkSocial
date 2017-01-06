<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

Class SiteController Extends PageController
{
    protected function getTemplateNames()
    {
        $this->templateInfo['templateNames'] = array('head', 'navbar', 'leftcolumn', 'middlecolumn', 'rightcolumn', 'footer');
    }
}
