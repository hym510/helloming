<?php

namespace App\Library\Profile;

use App\Models\{Equipment, Item, User, UserItem};

class Equip
{
    public static function upgrade($userId, $position): array
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
            ['max_level', 'upgrade', 'icon']
        );

        if ($equip['max_level'] == true) {
            return ['max'];
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
            return ['lack'];
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
            return ['lack'];
        }

        foreach ($equip['upgrade'] as $upgrade) {
            UserItem::where('user_id', $userId)
                ->where('item_id', $upgrade[0])
                ->decrement('quantity', $upgrade[1]);
        }

        User::equipUpgrade($userId, $equipPos);

        $upgEquip = Equipment::getKeyValue(
            [['level', $user[$equipPos] + 1],
             ['job_id', $user['job_id']],
             ['position', $position]],
            ['power', 'icon']
        );

        return ['success', $upgEquip];
    }

    public static function material($jobId, $level, $position): array
    {
        $equip = Equipment::getKeyValue(
            [['level', $level],
             ['job_id', $jobId],
             ['position', $position]],
            ['max_level', 'upgrade', 'icon']
        );

        if ($equip['max_level'] == true) {
            return $equip;
        }

        $material = array();

        foreach ($equip['upgrade'] as $upgrade) {
            $material[] = $upgrade[0];
        }

        $upgrade = Item::whereIn('id', $material)
            ->get(['id', 'name', 'quality', 'icon'])
            ->toArray();

        foreach ($upgrade as &$value) {
            foreach ($equip['upgrade'] as $v) {
                if ($v[0] == $value['id']) {
                    $value['quantity'] = $v[1];
                }
            }
        }

        $equip['upgrade'] = $upgrade;

        return $equip;
    }
}
