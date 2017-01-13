<?php

namespace App\Library\Event;

use Carbon\Carbon;
use App\Jobs\HostMining;
use App\Library\Event\Prize;
use App\Library\Redis\Redis;
use App\Models\{HostEvent, User};
use App\Models\Event as EventModel;
use Illuminate\Contracts\Bus\Dispatcher;

class Mining
{
    public static function start($hostEventId, $userId): bool
    {
        $event = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        if (! $event) {
            return false;
        }

        HostEvent::updateValue($hostEventId, ['created_at' => Carbon::now()]);

        $time = EventModel::getValue($event['event_id'], 'time');

        $job = (new HostMining($hostEventId))
            ->delay(Carbon::now()->addSeconds($time));

        app(Dispatcher::class)->dispatch($job);

        return true;
    }

    public static function complete($hostEventId, $userId): string
    {
        $hostEvent = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id', 'created_at']
        );

        if (! $hostEvent) {
            return 'finish';
        }

        $mine = EventModel::getKeyValue(
            [['id', $hostEvent['event_id']], ['type', 2]],
            ['exp', 'prize', 'time', 'finish_item_id', 'item_quantity']
        );

        if (! $mine) {
            return 'nonexist';
        }

        $created = strtotime($hostEvent['created_at']);
        $finish = $created + $mine['time'];
        $remain = $finish - time();

        if ($remain < 0) {
            $diamond = 0;
        } elseif (0 < $remain && $remain < 60) {
            $diamond = 1;
        } else {
            $diamond = $remain % 60;
        }

        if ($diamond) {
            if (! User::enough($userId, 'diamond', $diamond)) {
                return 'lack';
            }
        }

        Prize::get($hostEventId, $userId, $mine['exp'], $mine['prize']);

        Event::delete($userId, $hostEventId);

        return 'success';
    }

    public static function prize($userId, $hostEventId): array
    {
        $result = Redis::pipeline()->get('prize:' . $userId . ':' . $hostEventId)
            ->del('prize:' . $userId . ':' . $hostEventId)
            ->execute();

        return ['mine_prize' => json_decode($result[0])];
    }
}
