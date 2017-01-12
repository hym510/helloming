<?php

namespace App\Library\Event;

use Carbon\Carbon;
use App\Jobs\HostMining;
use App\Library\Redis\Redis;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Models\{Event, HostEvent, User, UserItem};

class Mining
{
    public static function start($hostEventId, $userId): int
    {
        $event = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id']
        );

        if (! $event) {
            return 0;
        }

        $time = Event::getValue($event['event_id'], 'time');

        $job = (new HostMining($hostEventId))
            ->delay(Carbon::now()->addSeconds($time));

        app(Dispatcher::class)->dispatch($job);

        return 1;
    }

    public static function complete($hostEventId, $userId): array
    {
        $hostEvent = HostEvent::getKeyValue(
            [['id', $hostEventId], ['user_id', $userId]],
            ['event_id', 'created_at']
        );

        if (! $hostEvent) {
            return ['finish'];
        }

        $mine = Event::getKeyValue(
            [['id', $hostEvent['event_id']], ['type', 'mine']],
            ['exp', 'prize', 'time', 'finish_item_id', 'item_quantity']
        );

        if (! $mine) {
            return ['nonexist'];
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
                return ['lack'];
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

        return ['prize', $prizeIds];
    }

    public static function prize($userId, $hostEventId): array
    {
        $result = Redis::pipeline()->get('prize:' . $userId . ':' . $hostEventId)
            ->del('prize:' . $userId . ':' . $hostEventId)
            ->execute();

        return ['mine_prize' => json_decode($result[0])];
    }
}
