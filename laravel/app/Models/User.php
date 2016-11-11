<?php

namespace App\Models;

use Redis;
use AuthToken;

class User extends Model
{
    protected $table = 'users';

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public static function signup(array $data): array
    {
        if (! isset($data['avatar'])) {
            $data['avatar'] = null;
        }

        $equipment = Equipment::where('level', 1)
            ->where('job_id', $data['job_id'])
            ->limit(3)
            ->get(['power']);
        $data['power'] = 0;

        foreach ($equipment as $e) {
            $data['power'] += $e['power'];
        }

        $data['remain_power'] = $data['power'];
        $authToken = AuthToken::genToken();
        $data['auth_token'] = $authToken;
        $data['created_at'] = date('Y-m-d H:i:s');
        $user = static::create($data);

        $userArray = static::where('id', $user->id)->first([
            'id', 'avatar', 'level', 'exp', 'vip_exp',
            'state', 'name', 'height', 'weight', 'gender',
            'age', 'online_time', 'job_id', 'zodiac', 'space',
            'take_up', 'power', 'remain_power', 'action', 'gold', 'diamond',
            'equipment1_level', 'equipment2_level', 'equipment3_level', 'activate'
        ])->toArray();

        Redis::pipeline()->hset('auth_tokens', $authToken, $user->id)
            ->sadd('phone_numbers', $data['phone'])
            ->hmset('user:'.$user->id, $userArray)
            ->execute();

        $userArray['auth_token'] = $authToken;

        return $userArray;
    }

    public static function mining($id)
    {
        static::where('id', $id)->increment('take_up', 1);
        Redis::hincrby('user:'.$id, 'take_up', 1);
    }

    public static function getProfile($id): array
    {
        return Redis::hgetall('user:'.$id);
    }

    public static function enough($id, $type, $cost): bool
    {
        if (Redis::hget('user:'.$id, $type) >= $cost) {
            static::where('id', $id)->decrement($type, $cost);
            Redis::hincrby('user:'.$id, $type, -$cost);

            return true;
        } else {
            return false;
        }
    }

    public static function free($id): bool
    {
        $space = Redis::hmget('user:'.$id, 'space', 'take_up');

        if ($space[0] > $space[1]) {
            return true;
        }

        return false;
    }

    public static function updateToken($phone): array
    {
        $authToken = AuthToken::genToken();

        $user = static::where('phone', $phone)->first([
            'id', 'auth_token as old_auth_token'
        ]);

        $user->auth_token = $authToken;

        static::where('phone', $phone)->update(['auth_token' => $authToken]);

        Redis::pipeline()->hdel('auth_tokens', $user->old_auth_token)
            ->hset('auth_tokens', $authToken, $user->id)
            ->execute();

        $profile = Redis::hgetall('user:'.$user->id);
        $profile['auth_token'] = $authToken;

        return $profile;
    }

    public static function updateProfile($id, array $data): array
    {
        unset($data['gender']);
        unset($data['job_id']);

        static::where('id', $id)->update($data);

        $userArray = static::where('id', $id)->first([
            'avatar', 'name', 'height',
            'weight', 'age', 'zodiac'
        ])->toArray();

        Redis::hmset('user:'.$id, $userArray);

        return Redis::hgetall('user:'.$id);
    }

    public static function addExp($id, $exp)
    {
        static::where('id', $id)->increment('exp', $exp);
        Redis::hincrby('user:'.$id, 'exp', $exp);
    }

    public static function freeSpace($id)
    {
        static::where('id', $id)->decrement('take_up', 1);
        Redis::hincrby('user:'.$id, 'take_up', -1);
    }

    public static function equipUpgrade($id, $position)
    {
        static::where('id', $id)->increment($position, 1);
        Redis::hincrby('user:'.$id, $position, 1);
    }

    public static function bindOpenid($id, $openid)
    {
        static::where('id', $id)->update('wechat_id', $openid);
        Redis::hset('user:'.$id, 'wechat_id', $openid);
    }
}
