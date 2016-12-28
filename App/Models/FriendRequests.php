<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class FriendRequests extends ModelQuery
{
    protected function setQueryParams()
    {
        $this->queryParams["select"] = array("string" => "SELECT u.first_name AS firstName, u.last_name AS lastName,
                                                                  ua.file_name AS avatarFile
                                                            FROM users u
                                                              LEFT JOIN users_avatars ua ON ua.user_id=u.id
                                                              JOIN friends f ON f.user_sender=u.id
                                                            WHERE f.user_receiver=:user_id AND f.status='unapplied'
                                                            ORDER BY f.created_at DESC",
            "params" => array("user_id" => ""));
    }
    protected function convertOutput()
    {
        $this->responseVars['friendReqs'] = array();
        foreach ($this->queryResult as $row) {
            if (empty($row['avatarFile'])) {
                $row['avatarFile'] = 'default.jpeg';
            }
            array_push($this->responseVars['friendReqs'], $row);
        }
    }
}
