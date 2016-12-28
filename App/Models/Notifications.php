<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Notifications extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT * FROM comments",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['unreadMessagesNum'] = 20;
        $this->responseVars['commentNewsNum'] = 1;
        $this->responseVars['commentPhotosNum'] = 3;
        $this->responseVars['commentAvatarNum'] = 1;
    }
}
