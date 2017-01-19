<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class GroupsAvatars extends ActiveRecord
{
    protected static $tableName = 'groups_avatars';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'file_name' => 'fileName',
                                     'group_id' => 'groupId',
                                     'status' => 'status',
                                    ];
}
