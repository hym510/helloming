<?php

namespace App\Contracts\Token;

interface AuthToken
{
    public static function genToken(): string;
}
