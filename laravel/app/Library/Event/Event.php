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

        $events = Event::random(Redis::hget('user:'.$userId, 'level'), $count);

        foreach ($events as &$event) {
            if ($event['type'] == 'mine') {
                $event['mine'] = Mine::find($event['mine_id'])->toArray();
                unset($event['monster_id']);
                unset($event['chest_id']);
            } elseif ($event['type'] == 'monster') {
                $event['monster'] = Monster::find($event['monster_id'])->toArray();
                unset($event['mine_id']);
                unset($event['chest_id']);
            } elseif ($event['type'] == 'chest') {
                $event['chest'] = Chest::getKeyValue(
                    [['id', $event['chest_id']]], ['cost_type', 'cost']
                );
                unset($event['mine_id']);
                unset($event['monster_id']);
            }
        }

        return $events;
    }
}
