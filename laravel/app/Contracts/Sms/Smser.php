<?php

namespace App\Contracts\Sms;

interface Smser
{
    public static function requestSmsCode($phone): bool;

    public static function verifySmsCode($phone, $code): bool;
}
