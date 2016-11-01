<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Pusher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Contracts\Push\Pusher';
    }
}
