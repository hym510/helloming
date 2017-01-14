<?php

namespace App\Library\Prize;

use Redis;
use App\Models\User;

class Prize
{
    public static function power($userId)
    {
        $data = Redis::pipeline()->get('replenish_time:' . $userId)
            ->get('power_time')
            ->hmget('user:' . $id, $type, 'remain_power', 'power')
            ->execute();

        if (! $data[0]) {
            Redis::set('replenish_time:' . $user->id, time());

            return;
        }

        $quantity = floor((time() - $data[0]) / $data[1][0]) * $data[1][1];
        $user = $data[2];

        if ($quantity + $user[0] >= $user[1]) {
            $quantity = $user[1] - $user[0];
        }

        Redis::hincrby('user:' . $userId, 'remain_power', $quantity);
        User::where('id', $id)->increment('remain_power', $quantity);
    }
}
