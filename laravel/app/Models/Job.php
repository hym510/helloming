<?php

namespace App\Models;

use Redis;

class Job extends Model
{
    protected $table = 'jobs';

    public static function getAll(): array
    {
        return json_decode(Redis::get('jobs'));
    }
}
