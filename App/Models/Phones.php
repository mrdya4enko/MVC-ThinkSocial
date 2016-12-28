<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Phones extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT phone AS phone FROM phones
                                                              WHERE user_id=:user_id",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['userPhones'] = array();
        foreach ($this->queryResult as $row) {
            array_push($this->responseVars['userPhones'], $row['phone']);
        }
    }
}
