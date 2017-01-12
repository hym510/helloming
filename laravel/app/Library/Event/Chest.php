<?php

namespace App\Library\Event;

use App\Models\{Event, User, UserItem};

class Chest
{
    public static function open($hostEventId, $userId): int
    {
        $event = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        $chest = Event::getKeyValue(
            [['id', $event['event_id'], ['type', 'chest']],
            ['exp', 'prize', 'finish_item_id', 'item_quantity']
        );

        if (! $chest) {
            return 0;
        }

        if ($chest['finish_item_id'] == 10000) {
            if (! User::enough($userId, 'gold', $chest['item_quantity'])) {
                return 0;
            }
        } elseif ($chest['finish_item_id'] == 10001) {
            if (! User::enough($userId, 'diamond', $chest['item_quantity'])) {
                return 0;
            }
        } else {
            $userItem = UserItem::getKeyValue(
                [['user_id', $userId], ['item_id', $chest['finish_item_id']]],
                ['quantity']
            );

            if ($userItem && $userItem['quantity'] >= $chest['item_quantity']) {
                UserItem::where('user_id', $userId)
                    ->where('item_id', $chest['finish_item_id'])
                    ->decrement('quantity', $chest['item_quantity']);
            } else {
                return 0;
            }
        }

        User::addExp($userId, $chest['exp']);
        $prizeIds = array();

        foreach ($chest['prize'] as $p) {
            if (is_lucky($p[1])) {
                $prizeIds[] = $p[0];
            }
        }

        UserItem::getPrize($prizeIds, $userId);

        return 1;
    }
}
