<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Phone extends ActiveRecord
{
    protected static $tableName = 'phones';
    protected static $tableFields = ["id" => "id",
        "user_id" => "userId",
        "phone" => "phone",
    ];
}
