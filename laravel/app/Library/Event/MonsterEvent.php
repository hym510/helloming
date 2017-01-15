<?php

namespace App\Library\Event;

use App\Library\Event\Prize;
use App\Library\Redis\Redis;
use App\Models\Event as EventModel;
use App\Models\{HostEvent, Monster};

class MonsterEvent
{
    public static function atk($hostEventId, $atk, $userId): bool
    {
        $event = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        if (! $event) {
            return false;
        }

        $monster = EventModel::getKeyValue(
            [['id', $event['event_id']], ['type', 1]],
            ['type_id', 'exp', 'prize']
        );

        if (! $monster) {
            return false;
        }

        if (! Monster::atk($monster['type_id'], $userId, $atk)) {
            return false;
        }

        Prize::get($hostEventId, $userId, $monster['exp'], $monster['prize']);

        Event::delete($userId, $hostEventId);

        return true;
    }
}
