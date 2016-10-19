<?php

namespace App\Contracts\Sms;

interface Smser
{
    public function requestSmsCode($phone);

    public function verifySmsCode($phone, $code);
}
