<?php

namespace App\Models;

class UserItem extends Model
{
    protected $table = 'user_items';

    public static function getAll($userId, $type): array
    {
        return static::join('items', 'user_items.item_id', '=', 'items.id')
            ->where('user_items.user_id', $userId)
            ->where('type', $type)
            ->orderBy('items.priority', 'desc')
            ->get([
                'user_items.id', 'items.name', 'items.icon',
                'items.info', 'user_items.quantity'
            ])
            ->toArray();
    }

    public static function getPrize($itemIds, $userId)
    {
        foreach ($itemIds as $itemId) {
            $count = static::where('user_id', $userId)->where('item_id', $itemId)->count();

            if ($count > 0) {
                static::where('user_id', $userId)->where('id', $itemId)->increment('quantity', 1);
            } else {
                static::create(['user_id' => $userId, 'item_id' => $itemId]);
            }
        }
    }
}
