<?php

namespace App\Models;

use App\Components\ActiveRecord;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class GroupsAvatars extends ActiveRecord
{
    const DEFAULT_AVATAR_PIC = "group-no-avatar.png";
    protected static $tableName = 'groups_avatars';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'file_name' => 'fileName',
                                     'group_id' => 'groupId',
                                     'status' => 'status',
                                    ];
}
