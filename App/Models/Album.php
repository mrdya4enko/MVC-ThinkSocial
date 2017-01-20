<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Album extends ActiveRecord
{
    protected static $tableName = 'albums';
    protected static $tableFields = [
                                     'id'   => 'id',
                                     'name' => 'name',
                                     'created_at' => 'createdAt'
                                    ];
}
