<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class AlbumUser extends ActiveRecord
{
    protected static $tableName = 'albums_users';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'user_id' => 'userId',
                                     'album_id' => 'albumId',
                                    ];
}
