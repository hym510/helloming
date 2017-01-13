<?php

namespace App\Library\Event;

use App\Library\Event\Prize;
use App\Models\Event as EventModel;
use App\Models\{HostEvent, User, UserItem};

class Chest
{
    public static function open($hostEventId, $userId): bool
    {
        $event = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        $chest = EventModel::getKeyValue(
            [['id', $event['event_id']], ['type', 'chest']],
            ['exp', 'prize', 'finish_item_id', 'item_quantity']
        );

        if (! $chest) {
            return false;
        }

        if ($chest['finish_item_id'] == 10000) {
            if (! User::enough($userId, 'gold', $chest['item_quantity'])) {
                return false;
            }
        } elseif ($chest['finish_item_id'] == 10001) {
            if (! User::enough($userId, 'diamond', $chest['item_quantity'])) {
                return false;
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
                return false;
            }
        }

        Prize::get($hostEventId, $userId, $chest['exp'], $chest['prize']);

        Event::delete($userId, $hostEventId);

        return true;
    }
}
