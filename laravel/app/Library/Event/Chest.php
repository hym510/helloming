<?php

namespace App\Library\Event;

use App\Models\{Event, Item, User, UserItem};

class Chest
{
    public static function open($eventId, $userId): array
    {
        $chest = Event::getKeyValue(
            [['id', $eventId], ['type', 'chest']],
            ['finish_item_id', 'item_quantity']
        );

        if (! $chest) {
            return [];
        }

        if ($chest['finish_item_id'] == 10000 && ！User::enough($userId, 'gold', $chest['item_quantity'])) {
            return [];
        } elseif ($chest['finish_item_id'] == 10001 && ！User::enough($userId, 'diamond', $chest['item_quantity'])) {
            return [];
        } else {
            $userItem = UserItem::getKeyValue(
                [['user_id', $userId], ['item_id', $chest['finish_item_id']]],
                ['quantity']
            );

            if ($userItem['quantity'] >= $chest['item_quantity']) {
                UserItem::where('user_id', $userId)
                    ->where('item_id', $chest['finish_item_id'])
                    ->decrement('quantity', $chest['item_quantity']);
            } else {
                return [];
            }
        }

        UserItem::manyPrize($event['prize'], $userId);

        return ['prize' => $chest['prize']];
    }
}
