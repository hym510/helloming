<?php

namespace App\Library\Token;

use App\Contracts\Token\AuthToken as AuthTokenContract;

class AuthToken implements AuthTokenContract
{
    public static function genToken(): string
    {
        return md5(openssl_random_pseudo_bytes(16).microtime());
    }
}
