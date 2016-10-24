<?php

namespace App\Library\Smser;

use App\Contracts\Sms\Smser as SmserContract;

class Smser implements SmserContract
{
    public function requestSmsCode($phone): bool
    {
        return true;
    }

    public function verifySmsCode($phone, $code): bool
    {
        return true;
    }
}
