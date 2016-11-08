<?php

namespace App\Models;

class HostEvent extends Model
{
    protected $table = 'host_events';

    public static function start($userId, $eventId, $mineId)
    {
        $model = static::create([
            'user_id' => $userId, 'event_id' => $eventId,
            'mine_id' => $mineId, 'created_at' => date('Y-m-d H:i:s')
        ]);

        return ['host_event_id' => $model->id];
    }
}
