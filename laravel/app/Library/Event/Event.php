<?php

namespace App\Library\Event;

use Redis;
use App\Models\Event as EventModel;

class Event
{
    public static function random($userId, $count): array
    {
        if ($count >= 6) {
            return [];
        }

        return ['events' => EventModel::random(Redis::hget('user:'.$userId, 'level'), $count)];
    }

    public static function addEvent($userId, $eventId, $longitude, $latitude)
    {
        $events = json_decode(Redis::get('user_event:' . $userId));
        $length = count($events);
        $newEvents = array();
        $lifeCycle = Redis::get('life_cycle');
        $now = date('Y-m-d H:i:s');

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]['created'] + $lifeCycle) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        if (count($newEvents) < 30) {
            $newEvents[] = array($userId, $eventId, $longitude, $latitude, $now);
        }

        Redis::set('user_event:' . $userId, json_encode($newEvents));
    }
}
