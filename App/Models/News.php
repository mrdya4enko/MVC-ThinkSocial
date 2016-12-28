<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class News extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT n.title AS title, n.text AS text, 
                                                                 n.picture AS picture, n.published AS published 
                                                          FROM news n
                                                              JOIN users_news un ON un.news_id=n.id
                                                              WHERE un.user_id=:user_id AND n.status='active'
                                                          ORDER BY n.published DESC",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['news'] = $this->queryResult;
    }
}
