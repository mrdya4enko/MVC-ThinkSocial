<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class UserAvatar extends ActiveRecord
{
    protected static $tableName = 'users_avatars';

    public static function getByForeign($foreignKey, $addCondition)
    {
        $result = parent::getByForeign($foreignKey, $addCondition);
        if (count($result) == 0) {
            $result = new UserAvatar();
            $result->user_id = $foreignKey['user_id'];
            $result->file_name = 'default.jpeg';
            return $result;
        }
        return $result[0];
    }
}
