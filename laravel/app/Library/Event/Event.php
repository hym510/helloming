<?php

namespace App\Library\Event;

use App\Library\Redis\Redis;
use App\Models\Event as EventModel;

class Event
{
    public static function all($userId): array
    {
        $data = Redis::pipeline()
            ->get('user_event:' . $userId)
            ->get('life_cycle')
            ->execute();
        $events = json_decode($data[0]);
        $length = count($events);
        $newEvents = array();
        $now = time();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->created + $data[1]) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        Redis::set('user_event:' . $userId, json_encode($newEvents));

        return $newEvents;
    }

    public static function addEvent($userId, $eventId, $longitude, $latitude)
    {
        $data = Redis::pipeline()
            ->get('user_event:' . $userId)
            ->get('life_cycle')
            ->execute();
        $events = json_decode($data[0]);
        $length = count($events);
        $newEvents = array();
        $now = time();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->created + $data[1]) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        if (count($newEvents) < 30) {
            $newEvents[] = [
                'event_id' => $eventId, 'longitude' => $longitude,
                'latitude' => $latitude, 'created' => $now
            ];
        }

        Redis::set('user_event:' . $userId, json_encode($newEvents));
    }

    public static function random($userId, $count): array
    {
        if ($count >= 6) {
            return [];
        }

        return ['events' => EventModel::random(Redis::hget('user:'.$userId, 'level'), $count)];
    }
}
