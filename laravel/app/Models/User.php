<?php

namespace App\Models;

use Redis;
use AuthToken;

class User extends Model
{
    protected $table = 'users';

    public static function updateToken($phone)
    {
        $authToken = AuthToken::genToken();
        $user = static::where('phone', $phone)->first([
            'id', 'name', 'avatar', 'auth_token as old_auth_token'
        ]);
        static::where('phone', $phone)->update(['auth_token' => $authToken]);
        $user->auth_token = $authToken;
        Redis::pipeline()->hdel('auth_tokens', $user->old_auth_token)
            ->hset('auth_token', $authToken, $user->id)
            ->execute();

        return $user->toArray();
    }

    public static function signup(array $data)
    {
        $authToken = AuthToken::genToken();
        if (! array_key_exists('avatar', $data)) {
            $data['avatar'] = null;
        }
        $user = static::create([
            'avatar' => $data['avatar'],
            'phone' => $data['phone'],
            'name' => $data['name'],
            'gender' => $data['gender'],
            'job_id' => $data['job_id'],
            'auth_token' => $authToken,
        ]);
        $userArray = static::where('id', $user->id)->first([
                'avatar', 'experience', 'vip_experience',
                'state', 'name', 'height', 'weight', 'gender',
                'online_time', 'job_id', 'zodiac', 'power',
                'action'
            ])->toArray();
        Redis::pipeline()->hset('auth_tokens', $authToken, $user->id)
            ->sadd('phone_numbers', $data['phone'])
            ->hmset('user:'.$user->id, $userArray)
            ->execute();
        $userArray['auth_token'] = $authToken;

        return $userArray;
    }
}
