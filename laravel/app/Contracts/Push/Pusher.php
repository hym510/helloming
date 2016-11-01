<?php

namespace App\Contracts\Push;

interface Pusher
{
    public function pushOne($userId, array $data);

    public function pushMany(array $userIds, array $data);
}
