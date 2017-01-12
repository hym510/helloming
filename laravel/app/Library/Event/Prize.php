<?php

namespace App\Library\Event;

use App\Models\{HostEvent, User, UserItem};

class Prize
{
    public static function get($hostEventId, $userId, $exp, $prize)
    {
        HostEvent::where('id', $hostEventId)->delete();
        User::freeSpace($userId);
        User::addExp($userId, $exp);
        UserItem::getPrize($prize, $userId);
    }
}
