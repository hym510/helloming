<?php

namespace App\Library\Event;

use Redis;
use App\Models\{Event, Fortune, Mine, Monster};

class Event
{
    public function random($userId): array
    {
        $events = Event::random(Redis::hget('user:'.$userId, 'level'));

        foreach ($events as &$event) {
            if ($event['type'] == 'mine') {
                $event['mine'] = Mine::find($event['mine_id'])->toArray();
                unset($event['monster_id']);
                unset($event['fortune_id']);
            } elseif ($event['type'] == 'monster') {
                $event['monster'] = Monster::find($event['monster_id'])->toArray();
                unset($event['mine_id']);
                unset($event['fortune_id']);
            } elseif ($event['type'] == 'fortune') {
                $event['fortune'] = Fortune::getKeyValue(
                    [['id', $event['fortune_id']]], ['cost_type', 'cost']
                );
                unset($event['mine_id']);
                unset($event['monster_id']);
            }
        }

        return $events;
    }
}
