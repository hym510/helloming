<?php

namespace App\Library\Event;

use App\Models\{Chest, Event, User, UserItem};

class Chest
{
    public function open($eventId, $userId): bool
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'chest']],
            ['chest_id']
        );

        if (! $event) {
            return false;
        }

        $chest = Chest::getKeyValue(
            [['id', $event['chest_id']]],
            ['cost_type', 'item_id', 'cost', 'prize']
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

                UserItem::manyPrize($chest['prize'], $userId);

                return true;
            }
        } elseif ($chest['cost_type'] == 'gold' && User::enough($userId, 'gold', $chest['cost'])) {
            UserItem::manyPrize($chest['prize'], $userId);

            return true;
        } elseif ($chest['cost_type'] == 'diamond' && User::enough($userId, 'diamond', $chest['cost'])) {
            UserItem::manyPrize($chest['prize'], $userId);

            return true;
        } elseif ($chest['cost_type'] == 'none') {
            UserItem::manyPrize($chest['prize'], $userId);

            return true;
        }
    }
}
