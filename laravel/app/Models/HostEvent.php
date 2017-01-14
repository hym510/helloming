<?php

namespace App\Models;

class HostEvent extends Model
{
    protected $table = 'host_events';

    public static function host($userId, $eventId, $longitude, $latitude): int
    {
        $model = static::create([
            'user_id' => $userId, 'event_id' => $eventId,
            'longitude' => $longitude, 'latitude' => $latitude,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        User::hostEvent($userId);

        return $model->id;
    }

    public static function getHost($userId): array
    {
        return static::where('user_id', $userId)
            ->get(['id', 'event_id', 'longitude', 'latitude', 'created_at'])
            ->toArray();
    }
}
