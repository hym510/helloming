<?php

namespace App\Library\Event;

use App\Models\{Event, HostMining, Item, Mine, User, UserItem};

class Mining
{
    public function start($eventId, $userId): array
    {
        if (! User::free($userId)) {
            return false;
        }

        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'mine']],
            ['mine_id']
        );

        if (! $event) {
            return [];
        }

        User::mining($userId);

        return HostMining::start($userId, $eventId, $event['mine_id']);
    }

    public function complete($hostMiningId, $userId): array
    {
        $hostMining = HostMining::getKeyValue(
            [['id', $hostMiningId], ['user_id', $userId]],
            ['event_id', 'mine_id']
        );

        if (! $hostMining) {
            return [];
        }

        $mine = Mine::getKeyValue(
            [['id', $hostMining['mine_id']]],
            ['consume_diamond']
        );

        if (! $mine) {
            return [];
        }

        if (! User::enough($userId, 'diamond', $mine['consume_diamond'])) {
            return [];
        }

        HostMining::where('id', $hostMiningId)->delete();
        $event = Event::getKeyValue(
            [['id', $hostMining['event_id']], ['type', 'mine']],
            ['prize']
        );
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
