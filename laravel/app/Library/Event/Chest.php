<?php

namespace App\Library\Event;

use App\Models\{Chest, Event, Item, User, UserItem};

class Chest
{
    public static function open($eventId, $userId): array
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'chest']],
            ['type_id', 'prize']
        );

        if (! $event) {
            return [];
        }

        $chest = Chest::getKeyValue(
            [['id', $event['type_id']]],
            ['cost_type', 'item_id', 'cost']
        );

        if ($chest['cost_type'] == 'item') {
            $userItem = UserItem::getKeyValue(
                [['user_id', $userId], ['item_id', $chest['item_id']]],
                ['quantity']
            );

            if ($userItem['quantity'] >= $chest['cost']) {
                UserItem::where('user_id', $userId)
                    ->where('item_id', $chest['item_id'])
                    ->decrement('quantity', $chest['cost']);
            } else {
                return [];
            }
        } elseif ($chest['cost_type'] == 'gold' && ! User::enough($userId, 'gold', $chest['cost'])) {
            return [];
        } elseif ($chest['cost_type'] == 'diamond' && ! User::enough($userId, 'diamond', $chest['cost'])) {
            return [];
        }

        UserItem::manyPrize($event['prize'], $userId);

        return ['prize' => $chest['prize']];
    }
}
