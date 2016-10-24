<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AuthToken extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Contracts\Token\AuthToken';
    }
}
