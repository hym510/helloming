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

    public static function getPrize($item, $userId)
    {
        foreach ($item as $i) {
            if ($i[0] == 10000) {
                User::replenishGold($userId, $i[1]);
            } elseif ($i[0] == 10001) {
                User::replenishDiamond($userId, $i[1]);
            } else {
                $count = static::where('user_id', $userId)->where('item_id', $i[0])->count();

                if ($count > 0) {
                    static::where('user_id', $userId)->where('item_id', $i[0])->increment('quantity', $i[1]);
                } else {
                    static::create(['user_id' => $userId, 'item_id' => $i[0], 'quantity' => $i[1]]);
                }
            }
        }
    }
}
