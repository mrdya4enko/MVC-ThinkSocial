<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class UserAvatar extends ModelQuery
{
    protected function setQueryParams()
    {
            $this->queryParams["select"] = array("string" => "SELECT ua.file_name AS avatarFile
                                                                FROM users_avatars ua
                                                              WHERE ua.user_id=:user_id
                                                                AND ua.status='active'",
                                            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars = empty($this->queryResult)? array('avatarFile' => 'default.jpeg') : $this->queryResult[0];
    }
}
