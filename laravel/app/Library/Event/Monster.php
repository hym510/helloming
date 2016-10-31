<?php

namespace App\Library\Event;

use App\Models\{Event, Item, Monster, User, UserItem};

class Monster
{
    public function atk($eventId, $atk, $userId): array
    {
        $event = Event::getValues($eventId, [
            'type', 'monster_id', 'mine_id', 'exp', 'prize'
        ]);

        if (Monster::atk($event['monster_id'], $atk) && User::power($userId, $atk)) {
            User::where('id', $userId)->increment('exp', $event['exp']);

            foreach ($event['prize'] as $p) {
                $prize = array();

                if (is_lucky($p[1])) {
                    UserItem::getPrize($p[0]);
                    $prize[] = $p[1];
                }

                $items = Item::whereIn('id', $prize)->get(['name', 'icon'])->toArray();

                return ['exp' => $event['exp'], 'prize' => $items];
            }
        } else {
            return [];
        }
    }
}
