<?php

namespace App\Library\Event;

use Redis;
use Carbon\Carbon;
use App\Jobs\HostMining;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Models\{Event, HostEvent, Item, Mine, User, UserItem};

class Mining
{
    public static function start($eventId, $userId): array
    {
        if (! User::free($userId)) {
            return [];
        }

        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'mine']],
            ['type_id', 'time']
        );

        if (! $event) {
            return [];
        }

        User::mining($userId);

        $hostEvent = HostEvent::start($userId, $eventId, $event['type_id']);

        $job = (new HostMining($hostEvent['host_event_id']))
                    ->delay(Carbon::now()->addSeconds($event['time']));

        app(Dispatcher::class)->dispatch($job);

        return $event;
    }

    public static function complete($hostEventId, $userId): array
    {
        $hostEvent = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        if (! $hostEvent) {
            return [];
        }

        $mine = Event::getKeyValue(
            [['id', $hostEvent['event_id']]], ['type', 'mine']],
            ['exp', 'finish_item_id', 'item_quantity']
        );

        if (! $mine) {
            return [];
        }

        if ($mine['finish_item_id'] == 10000 && ！User::enough($userId, 'gold', $mine['item_quantity'])) {
            return [];
        } elseif ($mine['finish_item_id'] == 10001 && ！User::enough($userId, 'diamond', $mine['item_quantity'])) {
            return [];
        } else {
            $userItem = UserItem::getKeyValue(
                [['user_id', $userId], ['item_id', $mine['finish_item_id']]],
                ['quantity']
            );

            if ($userItem['quantity'] >= $mine['item_quantity']) {
                UserItem::where('user_id', $userId)
                    ->where('item_id', $mine['finish_item_id'])
                    ->decrement('quantity', $mine['item_quantity']);
            } else {
                return [];
            }
        }

        HostEvent::where('id', $hostEventId)->delete();
        User::freeSpace($userId);
        User::addExp($userId, $event['exp']);

        $prizeIds = array();

        foreach ($event['prize'] as $p) {
            if (is_lucky($p[1])) {
                $prizeIds[] = $p[0];
            }
        }

        UserItem::getPrize($prizeIds, $userId);

        return ['prize' => prizeIds];
    }

    public static function host($userId): array
    {
        return ['host_events' => HostEvent::getMine($userId)];
    }

    public static function prize($userId): array
    {
        return ['mine_prize' => json_decode('['.Redis::getset('prize:'.$userId, '').']')];
    }
}
