<?php

namespace App\Models;

use Redis;
use App\Library\Token\AuthToken;

class User extends Model
{
    protected $table = 'users';

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function getAvatarAttribute($value)
    {
        return $value ? env('QINIU_DOMAIN').$value : null;
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
            'id', 'avatar', 'level', 'exp', 'vip_exp', 'state',
            'name', 'height', 'weight', 'gender', 'age', 'online_time',
            'job_id', 'zodiac', 'space', 'take_up',  'power',  'remain_power',
            'action', 'remain_action', 'gold', 'diamond', 'equipment1_level',
            'equipment2_level', 'equipment3_level', 'activate'
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
        $data = Redis::pipeline()
            ->get('level_attributes')
            ->get('state_attributes')
            ->hmget('user:'.$id, 'level', 'exp', 'state')
            ->execute();

        $levelAttr = json_decode($data[0]);
        $stateAttr = json_decode($data[1]);
        $userAttr = $data[2];
        $userExp = $userAttr[1] + $exp;

        if ($userExp >= $levelAttr[$userAttr[0] - 1]->exp) {
            $power = $levelAttr[$userAttr[0] - 1]->power;
            $action = $levelAttr[$userAttr[0] - 1]->action;

            static::where('id', $id)->update([
                'level' => $userAttr[0] + 1,
                'exp' => $userExp,
                'power' => $power,
                'action' => $action
            ]);

            Redis::pipeline()
                ->hincrby('user:'.$id, 'level', 1)
                ->hincrby('user:'.$id, 'exp', $exp)
                ->hmset('user:'.$id, 'power', $power, 'action', $action)
                ->execute();

            if ($stateAttr[$userAttr[2] - 1]->power) {
                static::where('id', $id)->update([
                    'state' => $userAttr[2] + 1,
                ]);

                Redis::hincrby('user:'.$id, 'state', 1);
            }
        } else {
            static::where('id', $id)->increment('exp', $exp);
            Redis::hincrby('user:'.$id, 'exp', $exp);
        }
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

    public static function consumeAction($id, $action): bool
    {
        if (Redis::hget('user:'.$id, 'remain_action') < $action) {
            return false;
        }

        static::where('id', $id)->decrement('remain_action', $action);
        Redis::hincrby('user:'.$id, 'remain_action', -$action);

        return true;
    }

    public static function ReplenishPower($id, $quantity): bool
    {
        $user = Redis::hmget('user:'.$id, 'diamond', 'remain_power', 'power');

        if ($user[0] < $quantity) {
            return false;
        }

        if ($user[1] + $quantity >= $user[2]) {
            $quantity = $user[2] - $user[1];
        }

        static::where('id', $id)->decrement('diamond', $quantity);
        Redis::hincrby('user:'.$id, 'diamond', -$quantity);

        static::where('id', $id)->increment('remain_power', $quantity);
        Redis::hincrby('user:'.$id, 'remain_power', $quantity);

        return true;
    }

    public static function ReplenishAction($id, $quantity): bool
    {
        if (Redis::hget('user:'.$id, 'diamond') < $quantity) {
            return false;
        }

        static::where('id', $id)->decrement('diamond', $quantity);
        Redis::hincrby('user:'.$id, 'diamond', -$quantity);

        static::where('id', $id)->increment('action', $quantity);
        Redis::hincrby('user:'.$id, 'action', $quantity);

        return true;
    }

    public static function ReplenishDiamond($id, $diamond)
    {
        static::where('id', $id)->increment('diamond', $diamond);
        Redis::hincrby('user:' . $id, 'diamond', $diamond);
    }

    public static function ReplenishGold($id, $gold)
    {
        static::where('id', $id)->increment('gold', $gold);
        Redis::hincrby('user:' . $id, 'gold', $gold);
    }

    public static function bindOpenid($id, $openid, $withdrawPassword): bool
    {
        if (Redis::hget('user:'.$id, 'wechat_id')) {
            return false;
        } else {
            static::where('id', $id)->update([
                'wechat_id' => $openid,
                'wechat_password' => Hash::make($withdrawPassword)
            ]);

            Redis::hset('user:'.$id, 'wechat_id', $openid);

            return true;
        }
    }

    public static function unbindOpenid($id)
    {
        static::where('id', $id)->update([
            'wechat_id' => null,
            'withdraw_password' => null
        ]);

        Redis::hset('user:'.$id, 'wechat_id', null);
    }
}
