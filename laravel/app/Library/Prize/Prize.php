<?php

namespace App\Library\Prize;

use App\Models\User;
use App\Library\Redis\Redis;

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

    public static function action($userId)
    {
        $data = Redis::pipeline()->get('free_shoe')
            ->hmget('user:' . $id, $type, 'remain_action', 'action')
            ->execute();

        $freeShoe = json_decode($data[0]);
        $now = time();
        $length = count($freeShoe);

        for ($i = 0; $i < $length; $i++) {
            $startTime = strtotime($freeShoe[$i]->time[0] . ':' . $freeShoe[$i]->time[1]);
            $endTime = $startTime + 1800;

            if ($now >= $startTime && $now <= $endTime) {
                $quantity = $freeShoe[$i]->quantity;
                $user = $data[1];

                if ($quantity + $user[0] >= $user[1]) {
                    $quantity = $user[1] - $user[0];
                }

                Redis::hincrby('user:' . $userId, 'remain_action', $quantity);
                User::where('id', $id)->increment('remain_action', $quantity);
                break;
            }
        }
    }
}
