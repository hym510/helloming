<?php

namespace App\Library\Smser;

use Config;
use Exception;
use App\Contracts\Sms\Smser as SmserContract;

class Smser implements SmserContract
{
    protected $url;

    protected $headers = [];

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
    }

    public function requestSmsCode($phone): bool
    {
        $data = json_encode(['mobilePhoneNumber' => $phone]);

        $ch = curl_init($this->url.'/1.1/requestSmsCode');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        try {
            $result = curl_exec($ch);
            curl_close($ch);
        } catch(Exception $e) {
            return false;
        }

        return empty(json_decode($result, true));
    }

    public function verifySmsCode($phone, $code): bool
    {
        $ch = curl_init($this->url.'/1.1/verifySmsCode/'.$code.'?mobilePhoneNumber='.$phone);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        try {
            $result = curl_exec($ch);
            curl_close($ch);
        } catch(Exception $e) {
            return false;
        }

        return empty(json_decode($result, true));
    }
}
