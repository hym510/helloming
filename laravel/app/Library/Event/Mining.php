<?php

namespace App\Library\Event;

use App\Models\{Event, HostEvent, Item, Mine, User, UserItem};

class Mining
{
    public function start($eventId, $userId): array
    {
        if (! User::free($userId)) {
            return [];
        }

        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'mine']],
            ['mine_id']
        );

        if (! $event) {
            return [];
        }

        User::mining($userId);

        return HostEvent::start($userId, $eventId, $event['mine_id']);
    }

    public function complete($hostEventId, $userId): array
    {
        $hostEvent = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id', 'mine_id']
        );

        if (! $hostEvent) {
            return [];
        }

        $mine = Mine::getKeyValue(
            [['id', $hostEvent['mine_id']]],
            ['consume_diamond']
        );

        if (! $mine) {
            return [];
        }

        if (! User::enough($userId, 'diamond', $mine['consume_diamond'])) {
            return [];
        }

        HostEvent::where('id', $hostEventId)->delete();
        $event = Event::getKeyValue(
            [['id', $hostEvent['event_id']], ['type', 'mine']],
            ['exp', 'prize']
        );
        User::addExp($userId, $event['exp']);

        $prizeIds = array();

        foreach ($event['prize'] as $p) {
            if (is_lucky($p[1])) {
                $prizeIds[] = $p[0];
            }
        }

        UserItem::getPrize($prizeIds, $userId);
        $items = Item::whereIn('id', $prizeIds)->get(['id', 'name', 'icon'])->toArray();

        return $items;
    }
}
