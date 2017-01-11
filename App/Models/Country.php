<?php
namespace App\Models;
/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Country extends ActiveRecord
{
    protected static $tableName = 'countries';
    protected static $tableFields = ["id" => "id",
        "name" => "name",
    ];
}
