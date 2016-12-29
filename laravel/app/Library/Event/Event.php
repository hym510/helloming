<?php

namespace App\Library\Event;

use Redis;
use App\Models\{Chest, Event, Mine, Monster};

class Event
{
    public static function random($userId, $count): array
    {
        if ($count >= 6) {
            return [];
        }

        return ['events' => Event::random(Redis::hget('user:'.$userId, 'level'), $count)];
    }
}
