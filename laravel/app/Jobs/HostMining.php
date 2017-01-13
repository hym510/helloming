<?php

namespace App\Jobs;

use Redis;
use Pusher;
use App\Models\HostEvent;
use Illuminate\Bus\Queueable;
use App\Models\Event as EventModel;
use App\Library\Event\{Event, Prize};
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HostMining implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    protected $hostEventId;

    public function __construct($hostEventId)
    {
        $this->hostEventId = $hostEventId;
    }

    public function handle()
    {
        $hostEvent = HostEvent::getKeyValue(
            [['id', $this->hostEventId]],
            ['user_id', 'event_id']
        );

        if (! $hostEvent) {
            return;
        }

        $event = EventModel::getKeyValue(
            [['id', $hostEvent['event_id']], ['type', 'mine']],
            ['exp', 'prize']
        );

        Prize::get($this->hostEventId, $hostEvent['user_id'], $event['exp'], $event['prize']);

        Event::delete($hostEvent['user_id'], $this->hostEventId);

        Pusher::pushOne(
            (string)$hostEvent['user_id'],
            ['host_event_id' => $this->hostEventId,
            'event_id' => $hostEvent['event_id'],
            'alert' => '你在FIND里面进行的事件已经完成, 前往查看!']
        );
    }
}
