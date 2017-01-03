<?php

namespace App\Library\Profile;

use App\Models\User;
use App\Library\Redis\Redis;

class Wechat
{
    public static function bind($userId, $openid): string
    {
        if (Redis::hget('user:'.$userId, 'wechat_id')) {
            return 'bound';
        }

        if (User::where('wechat_id', $openid)->first(['id'])){
            return 'exist';
        }

        User::bindOpenid($userId, $openid);

        return 'success';
    }
}
