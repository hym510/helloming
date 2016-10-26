<?php

namespace App\Models;

class UserItem extends Model
{
    protected $table = 'user_items';

    public static function getAll($userId, $type)
    {
        return static::join('items', 'user_items.item_id', '=', 'items.id')
            ->where('user_items.user_id', $userId)
            ->where('type', $type)
            ->orderBy('items.priority', 'desc')
            ->get([
                'user_items.id', 'items.name', 'items.icon',
                'items.info', 'user_items.quantity'
            ]);
    }
}
