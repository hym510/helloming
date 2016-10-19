<?php

namespace App\Library\Smser;

use App\Contracts\Sms\Smser as SmserContract;

class Smser implements SmserContract
{
    public function requestSmsCode($phone)
    {
        return true;
    }

    public function verifySmsCode($phone, $code)
    {
        return true;
    }
}
