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

        $atk *= 10;

        if (! Monster::atk($event['type_id'], $userId, $atk)) {
            return false;
        }

        $prizeIds = json_decode(Redis::set('user:monster:' . $userId));

        User::addExp($userId, array_shift($prizeIds));

        UserItem::getPrize($prizeIds, $userId);

        return true;
    }

    public static function prize($eventId, $userId): array
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'monster']],
            ['type_id', 'exp', 'prize']
        );

        if (! $event) {
            return [];
        }

        $hp = Monster::getValue($event['type_id'], 'hp');
        $power = User::getValue($userId, 'remain_power');

        if ($power >= $hp) {
            $prizeIds = array($event['exp']);

            foreach ($event['prize'] as $p) {
                if (is_lucky($p[1])) {
                    $prizeIds[] = $p[0];
                }
            }

            Redis::set('user:monster:' . $userId, json_encode($prizeIds));
        } else {
            return [];
        }

        return ['exp' => array_shift($prizeIds), 'prize' => $prizeIds];
    }
}
