<?php

namespace App\Contracts\Sms;

interface Smser
{
    public function requestSmsCode($phone): bool;

    public function verifySmsCode($phone, $code): bool;
}
