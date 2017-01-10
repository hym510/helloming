<?php

namespace App\Contracts\Push;

interface Pusher
{
    public function pushOne($userId, array $data): bool;

    public function pushMany(array $data, $pushTime = null): bool;
}
