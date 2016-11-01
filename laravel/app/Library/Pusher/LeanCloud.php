<?php

namespace App\Library\Pusher;

use Config;
use App\Contracts\Push\Pusher as PusherContract;

class LeanCloud implements PusherContract
{
    public function headers($master = false, $json = true): array
    {
        if ($master) {
            $appKey = Config::get('leancloud.master_key').',master';
        } else {
            $appKey = Config::get('leancloud.app_key');
        }

        $appId = Config::get('leancloud.app_id');
        $headers[] = 'X-LC-Id:'.$appId;
        $headers[] = 'X-LC-Key:'.$appKey;

        if ($json) {
            $headers[] = 'Content-Type:application/json';
        }

        return $headers;
    }

    public function pushOne($userId, array $data)
    {
        $data['action'] = 'cn.find.action';
        $data['badge'] = 'Increment';
        $data['sound'] = Config::get('leancloud.sound');
        $url = Config::get('leancloud.url').'/1.1/push';
        $pushData = json_encode([
            'where' => ['user_id' => (int)$userId],
            'prod' => Config::get('leancloud.prod'),
            'data' => $data,
            'expiration_interval' => '86400'
        ]);
        $headers = $this->headers();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pushData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    }

    public function pushMany(array $userIds, array $data)
    {
        $userIds = '('.implode(', ', $userIds).')';
        $data['action'] = 'cn.find.action';
        $data['badge'] = 'Increment';
        $url = Config::get('leancloud.url').'/1.1/push';
        $pushData = json_encode([
            'cql' => 'select * from _Installation where user_id in '.$userIds,
            'prod' => Config::get('leancloud.prod'),
            'data' => $data,
            'expiration_interval' => '86400'
        ]);
        $headers = $this->headers();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pushData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    }
}