<?php

namespace App\Library\Event;

use Redis;
use Carbon\Carbon;
use App\Jobs\HostMining;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Models\{Event, HostEvent, User, UserItem};

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
            ['event_id', 'created_at']
        );

        if (! $hostEvent) {
            return [];
        }

        $mine = Event::getKeyValue(
            [['id', $hostEvent['event_id']]], ['type', 'mine']],
            ['exp', 'prize', 'time', 'finish_item_id', 'item_quantity']
        );

        if (! $mine) {
            return [];
        }

        $created = strtotime($hostEvent->created_at);
        $finish = created + $mine['time'];
        $remain = $finish - time();

        if ($remain < 0) {
            $diamond = 0;
        } elseif (0 < $remain && $remain < 60) {
            $diamond = 1;
        } else {
            $diamond = $remain % 60;
        }

        if ($diamond) {
            if (！User::enough($userId, 'diamond', $diamond)) {
                return [];
            }
        }

        HostEvent::where('id', $hostEventId)->delete();
        User::freeSpace($userId);
        User::addExp($userId, $mine['exp']);

        $prizeIds = array();

        foreach ($mine['prize'] as $p) {
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

    public static function prize($userId, $hostEventId): array
    {
        $result = Redis::pipeline()->get('prize:' . $userId . ':' . $hostEventId)
            ->del('prize:' . $userId . ':' . $hostEventId)
            ->execute();

        return ['mine_prize' => json_decode($result[0])];
    }
}
