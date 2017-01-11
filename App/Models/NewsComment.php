<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class NewsComment extends ActiveRecord
{
    protected static $tableName = 'news_comments';
    protected static $tableFields = ["id" => "id",
        "news_id" => "newsId",
        "comment_id" => "commentId",
    ];
}
