<?php

namespace App\Library\Profile;

use App\Models\{Equipment, User};

class Equip
{
    public function upgrade($userId, $position): array
    {
        $equipPos = 'equipment'.$position.'_level';

        $user = User::getKeyValue(
            [['id', $userId]],
            ['job_id', $equipPos]
        );

        $equip = Equipment::getKeyValue(
            [['level', $user[$equipPos]], ['max_level', false],
            ['job_id', $user['job_id']], ['position', $position]],
            ['upgrade', 'icon']
        );

        if (! $equip) {
            return [];
        }
    }
}
