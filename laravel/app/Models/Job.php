<?php

namespace App\Models;

use App\Library\Redis\Redis;

class Job extends Model
{
    protected $fillable = [
        'id', 'name',
    ];

    protected $table = 'jobs';

    public static function getAll(): array
    {
        if ($jobs = Redis::get('jobs')) {
            return json_decode($jobs);
        } else {
            $jobs = Job::all()->toArray();
            Redis::set('jobs', json_encode($jobs));

            return $jobs;
        }
    }
}
