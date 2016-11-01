<?php

namespace App\Models;

class HostMining extends Model
{
    protected $table = 'host_mining';

    public static function start(array $data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        static::create($data);
    }
}
