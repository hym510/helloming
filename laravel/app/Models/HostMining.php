<?php

namespace App\Models;

class HostMining extends Model
{
    protected $table = 'host_mining';

    public static function start($userId, $eventId, $mineId)
    {
        $model = static::create([
            'user_id' => $userId, 'event_id' => $eventId,
            'mine_id' => $mineId, 'created_at' => date('Y-m-d H:i:s')
        ]);

        return ['host_mining_id' => $model->id];
    }
}
