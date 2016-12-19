<?php

namespace App\Models;

class HostEvent extends Model
{
    protected $table = 'host_events';

    public static function start($userId, $eventId, $mineId): array
    {
        $model = static::create([
            'user_id' => $userId, 'event_id' => $eventId,
            'mine_id' => $mineId, 'created_at' => date('Y-m-d H:i:s')
        ]);

        return ['host_event_id' => $model->id];
    }

    public static function getMine($userId): array
    {
        return static::join('events', 'host_events.mine_id', '=', 'mines.id')
            ->where('host_events.user_id', $userId)
            ->get([
                'host_events.id', 'host_events.event_id',
                'host_events.created_at'
            ])
            ->toArray();
    }
}
