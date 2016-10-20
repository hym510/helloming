<?php

namespace App\Models;

use Redis;

class PhoneNumber
{
    public static function isExist($phone)
    {
        return Redis::sismember('phone_numbers', $phone);
    }
}
