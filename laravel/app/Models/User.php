<?php

namespace App\Models;

use Redis;
use ApiToken;

class User extends Model
{
    protected $table = 'users';

    public static function updateToken($phone)
    {
        $apiToken = ApiToken::genToken();
        $user = static::where('phone', $phone)->first([
            'id', 'name', 'avatar', 'api_token as old_api_token'
        ]);
        static::where('phone', $phone)->update(['api_token' => $apiToken]);
        $user->api_token = $apiToken;
        Redis::pipeline()->hdel('api_tokens', $user->old_api_token)
            ->hset('api_tokens', $apiToken, $user->id)
            ->execute();

        return $user->toArray();
    }
}
