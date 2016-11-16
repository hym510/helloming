<?php

namespace App\Library\Smser;

use App\Contracts\Sms\Smser as SmserContract;

class Smser implements SmserContract
{
    public static function requestSmsCode($phone): bool
    {
        return true;
    }

    public static function verifySmsCode($phone, $code): bool
    {
        return true;
    }
}
