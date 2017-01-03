<?php

namespace App\Library\Redis;

use App\Models\User;
use Redis as BaseRedis;

class Redis extends BaseRedis
{
    public static function hgetall($key): array
    {
        $data = parent::hgetall($key);

        if ($data) {
            return $data;
        }

        $userId = explode(':', $key)[1];
        $user = User::find($userId)->toArray();

        Redis::hmset($key, $user);

        return $user;
    }
}
