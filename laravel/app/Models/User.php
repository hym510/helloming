<?php

namespace App\Models;

use Hash;
use App\Library\Redis\Redis;
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

        $levelAttr = LevelAttr::where('level', 1)
            ->first(['power', 'action']);

        $data['power'] = $levelAttr->power;
        $data['action'] = $levelAttr->action;

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
            'job_id', 'zodiac', 'space', 'take_up', 'power', 'remain_power',
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
        Redis::hincrby('user:'.$id, 'take_up', 1);
        static::where('id', $id)->increment('take_up', 1);
    }

    public static function getProfile($id): array
    {
        return Redis::hgetall('user:'.$id);
    }

    public static function enough($id, $type, $cost): bool
    {
        if (Redis::hget('user:'.$id, $type) >= $cost) {
            Redis::hincrby('user:'.$id, $type, -$cost);
            static::where('id', $id)->decrement($type, $cost);

            return true;
        } else {
            return false;
        }
    }

    public static function consumePower($id, $power)
    {
        $remainPower = Redis::hget('user:'.$id, 'remain_power');

        if ($remainPower >= $power) {
            Redis::hincrby('user:'.$id, 'remain_power', -$power);
            static::where('id', $id)->decrement('remain_power', $power);
        } else {
            Redis::hset('user:'.$id, 'remain_power', 0);
            static::where('id', $id)->update('remain_power', 0);
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

        if (! $data[0]) {
            $levelAttr = LevelAttr::orderBy('level', 'asc')->get()->toArray();
            Redis::set('level_attributes', json_encode($levelAttr));
        } else {
            $levelAttr = json_decode($data[0]);
        }

        if (! $data[1]) {
            $stateAttr = StateAttr::orderBy('level', 'asc')->get()->toArray();
            Redis::set('state_attributes', json_encode($stateAttr));
        } else {
            $stateAttr = json_decode($data[1]);
        }

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
                Redis::hincrby('user:'.$id, 'state', 1);

                static::where('id', $id)->update([
                    'state' => $userAttr[2] + 1,
                ]);
            }
        } else {
            Redis::hincrby('user:'.$id, 'exp', $exp);

            static::where('id', $id)->increment('exp', $exp);
        }
    }

    public static function freeSpace($id)
    {
        Redis::hincrby('user:'.$id, 'take_up', -1);

        static::where('id', $id)->decrement('take_up', 1);
    }

    public static function equipUpgrade($id, $position)
    {
        Redis::hincrby('user:'.$id, $position, 1);

        static::where('id', $id)->increment($position, 1);
    }

    public static function consumeAction($id, $action): bool
    {
        if (Redis::hget('user:'.$id, 'remain_action') < $action) {
            return false;
        }

        Redis::hincrby('user:'.$id, 'remain_action', -$action);
        static::where('id', $id)->decrement('remain_action', $action);

        return true;
    }

    public static function replenishPower($id, $quantity): bool
    {
        $expense = json_decode(Redis::get('expense'));

        foreach ($expense as $exp) {
            if ($exp->id == 2) {
                $data = $exp;
            }
        }

        if (! isset($data)) {
            return false;
        }

        switch ($data->currency) {
            case '10000':
                $type = 'gold';
                break;
            case '10001':
                $type = 'diamond';
        }

        $user = Redis::hmget('user:'.$id, $type, 'remain_power', 'power');

        $consume = $quantity * $data->price;

        if ($user[0] < $consume) {
            return false;
        }

        if ($user[1] + $quantity >= $user[2]) {
            $quantity = $user[2] - $user[1];
            $consume = $quantity * $data->price;
        }

        Redis::hincrby('user:'.$id, $type, -$consume);
        static::where('id', $id)->decrement($type, $consume);

        Redis::hincrby('user:'.$id, 'remain_power', $quantity);
        static::where('id', $id)->increment('remain_power', $quantity);

        return true;
    }

    public static function replenishAction($id, $quantity): bool
    {
        $expense = json_decode(Redis::get('expense'));

        foreach ($expense as $exp) {
            if ($exp->id == 1) {
                $data = $exp;
            }
        }

        if (! isset($data)) {
            return false;
        }

        switch ($data->currency) {
            case '10000':
                $type = 'gold';
                break;
            case '10001':
                $type = 'diamond';
        }
        $user = Redis::hmget('user:'.$id, $type, 'remain_action', 'action');

        $consume = $quantity * $data->price;

        if ($user[0] < $consume) {
            return false;
        }

        if ($user[1] + $quantity >= $user[2]) {
            $quantity = $user[2] - $user[1];
            $consume = $quantity * $data->price;
        }

        Redis::hincrby('user:'.$id, $type, -$consume);
        static::where('id', $id)->decrement($type, $consume);

        Redis::hincrby('user:'.$id, 'remain_action', $quantity);
        static::where('id', $id)->increment('remain_action', $quantity);

        return true;
    }

    public static function addSpace($id, $quantity): bool
    {
        $expense = json_decode(Redis::get('expense'));

        foreach ($expense as $exp) {
            if ($exp->id == 3) {
                $data = $exp;
            }
        }

        if (! isset($data)) {
            return false;
        }

        switch ($data->currency) {
            case '10000':
                $type = 'gold';
                break;
            case '10001':
                $type = 'diamond';
        }
        $user = Redis::hmget('user:'.$id, $type);

        $consume = $quantity * $data->price;

        if ($user[0] < $consume) {
            return false;
        }

        Redis::hincrby('user:'.$id, $type, -$consume);
        static::where('id', $id)->decrement($type, $consume);

        Redis::hincrby('user:'.$id, 'space', $quantity);
        static::where('id', $id)->increment('space', $quantity);

        return true;
    }

    public static function replenishDiamond($id, $diamond)
    {
        Redis::hincrby('user:' . $id, 'diamond', $diamond);

        static::where('id', $id)->increment('diamond', $diamond);
    }

    public static function replenishGold($id, $gold)
    {
        Redis::hincrby('user:' . $id, 'gold', $gold);

        static::where('id', $id)->increment('gold', $gold);
    }

    public static function bindUnionid($id, $unionid): bool
    {
        if (Redis::hget('user:'.$id, 'union_id')) {
            return false;
        } else {
            Redis::hset('user:'.$id, 'union_id', $unionid);

            static::where('id', $id)->update(['union_id' => $unionid]);

            return true;
        }
    }

    public static function unbindUnionid($id, $password): bool
    {
        $withdrawPwd = Redis::hget('user:'.$id, 'withdraw_password');

        if (! password_verify($password, $withdrawPwd)) {
            return false;
        }

        Redis::hset('user:'.$id, 'union_id', null);

        static::where('id', $id)->update(['union_id' => null]);

        return true;
    }

    public static function withdraw($id, $password)
    {
        $password = Hash::make($password);

        Redis::hset('user:'.$id, 'withdraw_password', $password);

        static::where('id', $id)->update(['withdraw_password' => $password]);
    }

    public function getGenderTypeAttribute(): string
    {
        if ($this->gender == 'male'){
            $gender = '男';
        } else {
            $gender = '女';
        }

        return $gender;
    }

    public function getZodiacTypeAttribute(): string
    {
        switch ($this->zodiac) {
            case 'aquarius':
                $zodiac = '水瓶座';
                break;
            case 'pisces':
                $zodiac = '双鱼座';
                break;
            case 'aries':
                $zodiac = '牡羊座';
                break;
            case 'taurus':
                $zodiac = '金牛座';
                break;
            case 'gemini':
                $zodiac = '双子座';
                break;
            case 'cancer':
                $zodiac = '巨蟹座';
                break;
            case 'leo':
                $zodiac = '狮子座';
                break;
            case 'virgo':
                $zodiac = '处女座';
                break;
            case 'libra':
                $zodiac = '天枰座';
                break;
            case 'scorpio':
                $zodiac = '天蝎座';
                break;
            case 'sagittarius':
                $zodiac = '射手座';
                break;
            case 'capricorn':
                $zodiac = '摩羯座';
                break;
        }

        return $zodiac;
    }
}
