<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\{Event, HostEvent, User, UserItem};

class HostMining
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

        HostEvent::where('id', $this->hostEventId)->delete();
        $event = Event::getKeyValue(
            [['id', $hostEvent['event_id']], ['type', 'mine']],
            ['exp', 'prize']
        );
        User::addExp($hostEvent['user_id'], $event['exp']);

        $prizeIds = array();

        foreach ($event['prize'] as $p) {
            if (is_lucky($p[1])) {
                $prizeIds[] = $p[0];
            }
        }

        UserItem::getPrize($prizeIds, $hostEvent['user_id']);
    }
}
