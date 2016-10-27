<?php

namespace App\Models;

use Redis;
use AuthToken;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    public static function signup(array $data): array
    {
        $authToken = AuthToken::genToken();

        if (! isset($data['avatar'])) {
            $data['avatar'] = null;
        }

        $data['auth_token'] = $authToken;
        $user = static::create($data);

        $userArray = static::where('id', $user->id)->first([
            'id', 'avatar', 'experience', 'vip_experience',
            'state', 'name', 'height', 'weight', 'gender',
            'age', 'online_time', 'job_id', 'zodiac',
            'power', 'action'
        ])->toArray();

        Redis::pipeline()->hset('auth_tokens', $authToken, $user->id)
            ->sadd('phone_numbers', $data['phone'])
            ->hmset('user:'.$user->id, $userArray)
            ->execute();

        $userArray['auth_token'] = $authToken;

        return $userArray;
    }

    public static function getProfile($id): array
    {
        return Redis::hgetall('user:'.$id);
    }

    public static function updateToken($phone): array
    {
        $apiToken = ApiToken::genToken();

        $user = static::where('phone', $phone)->first([
            'id', 'name', 'avatar', 'api_token as old_api_token'
        ]);
        $user->api_token = $apiToken;

        static::where('phone', $phone)->update(['api_token' => $apiToken]);

        Redis::pipeline()->hdel('api_tokens', $user->old_api_token)
            ->hset('api_tokens', $apiToken, $user->id)
            ->execute();

        return $user->toArray();
    }

    public static function updateProfile($id, array $data): array
    {
        static::where('id', $id)->update($data);

        $userArray = static::where('id', $id)->first([
            'avatar', 'experience', 'vip_experience',
            'state', 'name', 'height', 'weight', 'gender',
            'age', 'online_time', 'job_id', 'zodiac',
            'power', 'action'
        ])->toArray();

        Redis::hmset('user:'.$id, $userArray);

        return $userArray;
    }
}
