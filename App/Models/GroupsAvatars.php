<?php

namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Class GroupsAvatars
 * @package App\Models
 */
class GroupsAvatars extends ActiveRecord
{
    const DEFAULT_AVATAR_PIC = 'group-no-avatar.png';
    public $fileName;
    public $groupId;
    public $status = 'active';
    protected static $tableName = 'groups_avatars';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'file_name' => 'fileName',
                                     'group_id' => 'groupId',
                                     'status' => 'status',
                                    ];
}
