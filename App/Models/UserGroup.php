<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class UserGroup extends ActiveRecord
{
    protected static $tableName = 'users_groups';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'group_id' => 'groupId',
                                     'user_id' => 'userId',
                                    ];
}
