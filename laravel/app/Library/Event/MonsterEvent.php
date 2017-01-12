<?php

namespace App\Library\Event;

use App\Library\Event\Prize;
use App\Library\Redis\Redis;
use App\Models\{Event, HostEvent, Monster};

class MonsterEvent
{
    public static function atk($hostEventId, $atk, $userId): bool
    {
        $event = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        $monster = Event::getKeyValue(
            [['id', $event['event_id']], ['type', 'monster']],
            ['type_id', 'exp', 'prize']
        );

        if (! $monster) {
            return false;
        }

        if (! Monster::atk($monster['type_id'], $userId, $atk)) {
            return false;
        }

        Prize::get($hostEventId, $userId, $monster['exp'], $monster['prize']);

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
