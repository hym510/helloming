<?php

namespace App\Library\Event;

use App\Models\{HostEvent, User, UserItem};

class Prize
{
    public static function get($userId, $exp, $prize)
    {
        User::addExp($userId, $exp);
        UserItem::getPrize($prize, $userId);
    }
}
