<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Smser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Contracts\Sms\Smser';
    }
}
