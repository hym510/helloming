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

    public static function signup(array $data)
    {
        $apiToken = ApiToken::genToken();
        if (! array_key_exists('avatar', $data)) {
            $data['avatar'] = null;
        }
        $user = static::create([
            'avatar' => $data['avatar'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'job_id' => $data['job_id'],
            'api_token' => $apiToken,
        ]);
        $userArray = static::where('id', $user->id)->first([
                'avatar', 'experience', 'vip_experience',
                'state', 'name', 'height', 'weight', 'gender',
                'online_time', 'job_id', 'zodiac', 'power',
                'action'
            ])->toArray();
        Redis::pipeline()->hset('api_tokens', $apiToken, $user->id)
            ->sadd('phone_numbers', $data['phone'])
            ->hmset('user:'.$user->id, $userArray)
            ->execute();
        $userArray['api_token'] = $apiToken;

        return $userArray;
    }
}
