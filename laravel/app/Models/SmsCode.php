<?php

namespace App\Models;

use Redis;

class SmsCode
{
    public static function genCode($phone)
    {
        Redis::setex('phone:'.$phone, 600, mt_rand(100000, 999999));
    }
}
