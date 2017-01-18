<?php
namespace App\Models;

use App\Components\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: bond
 * Date: 12.12.16
 * Time: 13:29
 */

class Message extends ActiveRecord
{
    protected static $tableName = 'messages';
    protected static $tableFields = [
                                     'id' => 'id',
                                     'sender_id' => 'senderId',
                                     'receiver_id' => 'receiverId',
                                     'text' => 'text',
                                     'status' => 'status',
                                     'created_at' => 'createdAt',
                                    ];
}
