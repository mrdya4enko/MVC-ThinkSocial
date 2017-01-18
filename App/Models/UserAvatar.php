<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class UserAvatar extends ActiveRecord
{
    protected static $tableName = 'users_avatars';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'user_id' => 'userId',
                                     'file_name' => 'fileName',
                                     'status' => 'status',
                                    ];

    public static function getByCondition($condition, $addCondition='')
    {
        $result = parent::getByCondition($condition, $addCondition);
        if (count($result) == 0) {
            $result = new UserAvatar();
            $result->userId = $condition['userId'];
            $result->fileName = 'default.jpeg';
            return $result;
        }
        return $result[0];
    }
}
