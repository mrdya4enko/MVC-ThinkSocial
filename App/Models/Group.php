<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Group extends ActiveRecord
{
    protected static $tableName = 'groups';
    protected static $tableFields = ["id" => "id",
        "name" => "name",
        "description" => "description",
        "status" => "status",
    ];
}
