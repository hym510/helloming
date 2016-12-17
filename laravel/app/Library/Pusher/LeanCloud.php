<?php

namespace App\Library\Pusher;

use Config;
use Exception;
use App\Contracts\Push\Pusher as PusherContract;

class LeanCloud implements PusherContract
{
    protected $url;

    protected $headers = [];

    protected $setting = [];

    public function __construct($master = false)
    {
        $this->url = Config::get('leancloud.url');

        if ($master) {
            $appKey = Config::get('leancloud.master_key').',master';
        } else {
            $appKey = Config::get('leancloud.app_key');
        }

        array_push($this->headers,
            'Content-Type:application/json',
            'X-LC-Id:'.Config::get('leancloud.app_id'),
            'X-LC-Key:'.$appKey
        );

        $this->setting = [
            'action' => 'cn.find.action',
            'badge' => 'Increment',
            'sound' => Config::get('leancloud.sound')
        ];
    }

    public function pushOne($userId, array $data): bool
    {
        $pushData = json_encode([
            'where' => ['user_id' => (int)$userId],
            'prod' => Config::get('leancloud.prod'),
            'data' => array_merge($this->setting, $data),
            'expiration_interval' => '86400',
        ]);

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pushData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        try {
            $result = curl_exec($ch);
            curl_close($ch);
        } catch(Exception $e) {
            return false;
        }

        return true;
    }

    public function pushMany(array $userIds, array $data): bool
    {
        $userIds = '('.implode(', ', $userIds).')';
        $url = Config::get('leancloud.url').'/1.1/push';
        $pushData = json_encode([
            'cql' => 'select * from _Installation where user_id in '.$userIds,
            'prod' => Config::get('leancloud.prod'),
            'data' => array_merge($this->setting, $data),
            'expiration_interval' => '86400',
        ]);
        $headers = $this->headers();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pushData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        try {
            $result = curl_exec($ch);
            curl_close($ch);
        } catch(Exception $e) {
            return false;
        }

        return true;
    }
}
