<?php

namespace App\Library\Event;

use App\Models\{Chest, Event, Item, User, UserItem};

class Chest
{
    public function open($eventId, $userId): array
    {
        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'chest']],
            ['chest_id']
        );

        if (! $event) {
            return [];
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
            } else {
                return [];
            }
        } elseif ($chest['cost_type'] == 'gold' && ! User::enough($userId, 'gold', $chest['cost'])) {
            return [];
        } elseif ($chest['cost_type'] == 'diamond' && ! User::enough($userId, 'diamond', $chest['cost'])) {
            return [];
        }

        $prizeIds = UserItem::manyPrize($chest['prize'], $userId);
        $items = Item::whereIn('id', $prizeIds)->get(['id', 'name', 'icon']);

        foreach ($chest['prize'] as $p) {
            $item = $items->where('id', $p[0])->first();
            $item->quantity = $p[1];
        }

        return $items->toArray();
    }
}
