<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class UserNews extends ActiveRecord
{
    protected static $tableName = 'users_news';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'news_id' => 'newsId',
                                     'user_id' => 'userId',
                                    ];
}
