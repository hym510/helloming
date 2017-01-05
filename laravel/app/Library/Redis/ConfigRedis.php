<?php

namespace App\Library\Redis;

use Redis as BaseRedis;
use App\Models\Configure;

class ConfigRedis extends BaseRedis
{
    public static function get($key)
    {
        $data = call_user_func('parent::get', $key);

        if ($data) {
            return $data;
        }

        $value = Configure::where('key', $key)->first(['value'])->value;
        call_user_func_array('parent::set', array($key, $value));

        return $value;
    }
}
