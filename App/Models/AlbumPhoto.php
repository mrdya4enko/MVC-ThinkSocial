<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class AlbumPhoto extends ActiveRecord
{
    protected static $tableName = 'albums_photos';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'album_id' => 'albumId',
                                     'file_name' => 'fileName',
                                     'description' => 'description',
                                     'status' => 'status',
                                    ];
}
