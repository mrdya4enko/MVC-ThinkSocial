<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:31
 */

class SiteController extends PageController
{


    public function actionIndex($id='')
    {
        $result = parent::actionIndex($id);
        $result['templateNames'] = [
                                    'head',
                                    'navbar',
                                    'leftcolumn',
                                    'middlecolumn',
                                    'rightcolumn',
                                    'footer',
                                   ];
        return $result;
    }
}
