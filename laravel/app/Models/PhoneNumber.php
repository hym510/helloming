<?php

namespace App\Models;

use App\Library\Redis\Redis;

class PhoneNumber
{
    public static function isExist($phone): bool
    {
        return Redis::sismember('phone_numbers', $phone);
    }
}
