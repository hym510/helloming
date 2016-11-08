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
                'items.id as item_id', 'items.name', 'items.icon',
                'items.info', 'user_items.quantity'
            ])
            ->toArray();
    }

    public static function getPrize($itemIds, $userId)
    {
        foreach ($itemIds as $itemId) {
            $count = static::where('user_id', $userId)->where('item_id', $itemId)->count();

            if ($count > 0) {
                static::where('user_id', $userId)->where('item_id', $itemId)->increment('quantity', 1);
            } else {
                static::create(['user_id' => $userId, 'item_id' => $itemId]);
            }
        }
    }

    public static function manyPrize($prize, $userId): array
    {
        $prizeIds = array();

        foreach ($prize as $p) {
            $prizeIds[] = $p[0];
            $count = static::where('user_id', $userId)->where('item_id', $p[0])->count();

            if ($count > 0) {
                static::where('user_id', $userId)->where('item_id', $p[0])->increment('quantity', $p[1]);
            } else {
                static::create(['user_id' => $userId, 'item_id' => $p[0], 'quantity' => $p[1]]);
            }
        }

        return $prizeIds;
    }
}
