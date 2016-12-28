<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Albums extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT ap.file_name AS fileName, a.name AS albumName
                                                            FROM albums_photos ap
                                                                JOIN albums a ON ap.album_id=a.id
                                                                JOIN albums_users au ON au.album_id=a.id
                                                            WHERE au.user_id=:user_id",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['userAlbums'] = $this->queryResult;
    }
}
