<?php

namespace App\Library\Event;

use App\Models\{Event, HostMining, User};

class Mining
{
    public function start($eventId, $userId): bool
    {
        if (! User::free($userId)) {
            return false;
        }

        $event = Event::getKeyValue(
            [['id', $eventId], ['type', 'mine']],
            ['mine_id']
        );

        if ($event) {
            User::mining($userId);
            HostMining::start($userId, $eventId, $event['mine_id']);

            return true;
        }

        return false;
    }
}
