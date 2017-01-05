<?php

namespace App\Library\Redis;

use Redis as BaseRedis;
use App\Models\Configure;

class ConfigRedis extends BaseRedis
{
    public static function get($key)
    {
        $data = call_user_func_array('parent::get', $key);

        if ($data) {
            return $data;
        }

        return Configure::where('key', $key)->first(['value']);
    }
}
