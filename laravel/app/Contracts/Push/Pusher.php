<?php

namespace App\Contracts\Push;

interface Pusher
{
    public function pushOne($userId, array $data): bool;

    public function pushMany(array $userIds, array $data): bool;
}
