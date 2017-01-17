<?php

namespace App\Library\Event;

use App\Models\{HostEvent, User, UserItem};

class Prize
{
    public static function get($hostEventId, $userId, $exp, $prize)
    {
        User::addExp($userId, $exp);
        UserItem::getPrize($prize, $userId);
    }
}
