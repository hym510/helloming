<?php

namespace App\Library\Event;

use App\Models\{Event, Item, Monster, User, UserItem};

class Monster
{
    public function atk($eventId, $atk, $userId): array
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'monster']],
            ['monster_id', 'exp', 'prize']
        );

        if (! $event) {
            return [];
        }

        if (! Monster::atk($event['monster_id'], $atk) || ! User::enough($userId, 'remain_power', $atk)) {
            return [];
        }

        User::where('id', $userId)->increment('exp', $event['exp']);

        $prizeIds = array();

        foreach ($event['prize'] as $p) {
            if (is_lucky($p[1])) {
                $prizeIds[] = $p[0];
            }
        }

        UserItem::getPrize($prizeIds, $userId);
        $items = Item::whereIn('id', $prizeIds)->get(['name', 'icon'])->toArray();

        return ['exp' => $event['exp'], 'prize' => $items];
    }
}
