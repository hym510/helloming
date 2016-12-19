<?php

namespace App\Library\Profile;

use App\Models\{Equipment, Item, User, UserItem};

class Equip
{
    public static function upgrade($userId, $position): string
    {
        $equipPos = 'equipment'.$position.'_level';

        $user = User::getKeyValue(
            [['id', $userId]],
            ['job_id', $equipPos]
        );

        $equip = Equipment::getKeyValue(
            [['level', $user[$equipPos]],
             ['job_id', $user['job_id']],
             ['position', $position]],
            ['max_level', 'upgrade']
        );

        if ($equip['max_level'] == true) {
            return 'max';
        }

        $enough = 0;
        $itemIds = array();
        $count = count($equip['upgrade']);

        foreach ($equip['upgrade'] as $item) {
            $itemIds[] = $item[0];
        }

        $items = UserItem::where('user_id', $userId)
            ->whereIn('item_id', $itemIds)
            ->get(['item_id', 'quantity']);

        if ($items->count() < $count) {
            return 'lack';
        }

        foreach ($equip['upgrade'] as $upgrade) {
            $item = $items->where('item_id', $upgrade[0])->first();

            if (! $item) {
                return [];
            } elseif($item['quantity'] >= $upgrade[1]) {
                $enough++;
            }
        }

        if ($enough != $count) {
            return 'lack';
        }

        foreach ($equip['upgrade'] as $upgrade) {
            UserItem::where('user_id', $userId)
                ->where('item_id', $upgrade[0])
                ->decrement('quantity', $upgrade[1]);
        }

        User::equipUpgrade($userId, $equipPos);

        return 'success';
    }
}
