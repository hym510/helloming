<?php

namespace App\Library\Event;

use App\Models\{Event, Monster, User, UserItem};

class MonsterEvent
{
    public static function atk($eventId, $atk, $userId): array
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'monster']],
            ['type_id', 'exp', 'prize']
        );

        if (! $event) {
            return [];
        }

        $atk *= 10;

        if (! Monster::atk($event['type_id'], $userId, $atk)) {
            return [];
        }

        User::addExp($userId, $event['exp']);

        $prizeIds = array();

        foreach ($event['prize'] as $p) {
            if (is_lucky($p[1])) {
                $prizeIds[] = $p[0];
            }
        }

        UserItem::getPrize($prizeIds, $userId);

        return ['exp' => $event['exp'], 'prize' => $prizeIds];
    }
}
