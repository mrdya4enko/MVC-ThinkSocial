<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class City extends ActiveRecord
{
    protected static $tableName = 'cities';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'country_id' => 'countryId',
                                     'name' => 'name',
                                    ];
}
