<?php

namespace App\Library\Smser;

use Log;
use Config;
use GuzzleHttp\Client;
use App\Contracts\Sms\Smser as SmserContract;

class Smser implements SmserContract
{
    private $url;
    private $appId;
    private $appKey;
    private $masterKey;
    private $client;

    public function __construct($master = false)
    {
        $cfg = Config::get('leancloud');
        $this->url = $cfg['url'];
        $this->appId = $cfg['app_id'];
        $this->appKey = $cfg['app_key'];
        $this->masterKey = $cfg['master_key'];

        $this->client = new Client([
            'allow_redirects' => false,
            'http_errors' => false,
            'base_uri' => $this->url,
            'headers' => [
                'User-Agent' => 'Funshow (ganguo)',
                'X-LC-Id' => $this->appId,
                'X-LC-Key' => ($master && $this->masterKey) ? ($this->masterKey.',master') : $this->appKey,
            ],
            'timeout' => '60',
        ]);
    }

    private function handleResponse($response)
    {
        if (substr($response->getStatusCode(), 0, 1) != 2) {
            $message = (string) $response->getBody();
            error_log($message);
            Log::error($message);

            return false;
        }

        return true;
    }

    public function requestSmsCode($phone): bool
    {
        $response = $this->client->post('/1.1/requestSmsCode', [
            'json' => ['mobilePhoneNumber' => $phone],
        ]);

        return $this->handleResponse($response);
    }

    public function verifySmsCode($phone, $code): bool
    {
        $response = $this->client->post('/1.1/verifySmsCode/'.$code.'?mobilePhoneNumber='.$phone, [
            'headers' => ['Content-Type' => 'application/json'],
        ]);

        return $this->handleResponse($response);
    }
}
