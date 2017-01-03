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

        parent::hmset($key, $user);

        return $user;
    }

    public static function hget(...$args)
    {
        $data = call_user_func_array('parent::hget', $args);

        if ($data) {
            return $data;
        }

        $userId = explode(':', $args[0])[1];
        $user = User::find($userId)->toArray();

        parent::hmset($args[0], $user);

        return call_user_func_array('parent::hget', $args);
    }
}
