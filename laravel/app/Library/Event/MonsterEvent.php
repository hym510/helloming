<?php

namespace App\Library\Event;

use App\Library\Redis\Redis;
use App\Models\{Event, Monster, User, UserItem};

class MonsterEvent
{
    public static function atk($eventId, $atk, $userId): bool
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'monster']],
            ['type_id', 'exp', 'prize']
        );

        if (! $event) {
            return false;
        }

        if (! Monster::atk($event['type_id'], $userId, $atk)) {
            return false;
        }

        $prizeIds = json_decode(Redis::get('user:monster:' . $userId));

        User::addExp($userId, array_shift($prizeIds));

        UserItem::getPrize($prizeIds, $userId);

        return true;
    }

    public static function prize($eventId, $userId): array
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'monster']],
            ['exp', 'prize']
        );

        if (! $event) {
            return [];
        }

        return ['exp' => $event['exp'], 'prize' => $event['prize'];
    }
}
