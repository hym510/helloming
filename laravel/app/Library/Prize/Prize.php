<?php

namespace App\Library\Prize;

use App\Models\User;
use App\Library\Redis\ConfigRedis;

class Prize
{
    public static function power($userId)
    {
        $data = ConfigRedis::pipeline()->get('replenish_time:' . $userId)
            ->get('power_time')
            ->hmget('user:' . $userId, 'remain_power', 'power')
            ->execute();

        if (! $data[0]) {
            ConfigRedis::set('replenish_time:' . $userId, time());

            return;
        }

        $user = $data[2];
        ConfigRedis::set('replenish_time:' . $userId, time());

        if ($user[0] >= $user[1]) {
            return;
        }


        $powerTime = json_decode($data[1]);
        $quantity = floor((time() - $data[0]) / $powerTime[0]) * $powerTime[1];

        if ($quantity + $user[0] >= $user[1]) {
            $quantity = $user[1] - $user[0];
        }

        ConfigRedis::hincrby('user:' . $userId, 'remain_power', $quantity);
        User::where('id', $userId)->increment('remain_power', $quantity);
    }

    public static function action($userId)
    {
        $data = ConfigRedis::pipeline()->get('free_shoe')
            ->hmget('user:' . $userId, 'remain_action', 'action')
            ->execute();

        $freeShoe = json_decode($data[0]);
        $now = time();
        $length = count($freeShoe);

        for ($i = 0; $i < $length; $i++) {
            $time = $freeShoe[$i]->time;
            $startTime = strtotime($time[1].$time[2].':'.$time[4].$time[5]);

            if ($now >= $startTime && $now <= $startTime + 1800) {
                $quantity = $freeShoe[$i]->quantity;
                $user = $data[1];

                if ($quantity + $user[0] >= $user[1]) {
                    $quantity = $user[1] - $user[0];
                }

                ConfigRedis::hincrby('user:' . $userId, 'remain_action', $quantity);
                User::where('id', $userId)->increment('remain_action', $quantity);
                break;
            }
        }
    }
}
