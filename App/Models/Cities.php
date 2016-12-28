<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Cities extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT ci.name AS city, co.name AS country
                                                              FROM cities ci
                                                                  JOIN countries co ON ci.country_id=co.id
                                                                  JOIN users_cities uc ON ci.id=uc.city_id
                                                              WHERE uc.user_id=:user_id
                                                                  ORDER BY uc.id",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['userCities'] = $this->queryResult;
    }
}
