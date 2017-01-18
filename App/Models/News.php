<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class News extends ActiveRecord
{
    protected static $tableName = 'news';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'title' => 'title',
                                     'text' => 'text',
                                     'picture' => 'picture',
                                     'status' => 'status',
                                     'published' => 'published',
                                    ];
}
