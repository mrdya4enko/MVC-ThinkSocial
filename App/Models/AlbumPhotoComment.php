<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class AlbumPhotoComment extends ActiveRecord
{
    protected static $tableName = 'albums_photos_comments';
    protected static $tableFields = ["id" => "id",
        "comment_id" => "commentId",
        "albums_photos_id" => "albumPhotoId",
    ];
}
