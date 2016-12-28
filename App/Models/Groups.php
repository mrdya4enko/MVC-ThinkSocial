<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Groups extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT g.name AS groupName
                                                              FROM groups g
                                                                  JOIN users_groups ug ON ug.group_id=g.id
                                                              WHERE ug.user_id=:user_id
                                                                  ORDER BY g.name",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['groupArray'] = array();
        foreach ($this->queryResult as $row) {
            array_push($this->responseVars['groupArray'], $row['groupName']);
        }
    }
}