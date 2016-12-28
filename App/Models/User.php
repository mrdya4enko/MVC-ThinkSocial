<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class User extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT u.first_name AS userFirstName,  u.middle_name AS userMiddleName,
                                                                 u.last_name AS userLastName, u.email AS userEmail,
                                                                 u.birthday AS userBirthday, u.sex AS userSex
                                                              FROM users u
                                                              WHERE u.id=:user_id",
                                            "params" => array("user_id" => ""));
        $this->queryParams["update"] = array("string" => "UPDATE users
                                                              SET first_name=:userFirstName,  middle_name=:userMiddleName,
                                                                  last_name=:userLastName
                                                              WHERE id=:user_id",
                                             "params" => array("userFirstName" => "",  "userMiddleName" => "", "userLastName" => "",
                                                                /*"userBirthday" => "", "userSex" => "", */"user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars = $this->queryResult[0];
    }
}
