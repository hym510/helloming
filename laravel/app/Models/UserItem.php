<?php

namespace App\Models;

class UserItem extends Model
{
    protected $table = 'user_items';

    public static function getAll($userId): array
    {
        return static::where('user_id', $userId)
            ->get(['item_id', 'quantity'])
            ->toArray();
    }

    public static function getPrize($itemIds, $userId)
    {
        foreach ($itemIds as $itemId) {
            if ($itemId == 10000) {
                User::replenishGold($userId, 1);
            } elseif ($itemId == 10001) {
                User::replenishDiamond($userId, 1);
            } else {
                $count = static::where('user_id', $userId)->where('item_id', $itemId)->count();

                if ($count > 0) {
                    static::where('user_id', $userId)->where('item_id', $itemId)->increment('quantity', 1);
                } else {
                    static::create(['user_id' => $userId, 'item_id' => $itemId]);
                }
            }
        }
    }
}
