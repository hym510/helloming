<?php

namespace App\Library\Qiniu;

use Config;
use Qiniu\Auth;
use GuzzleHttp\Client;
use Qiniu\Storage\UploadManager;

class Qiniu
{
    private $accessKey;

    private $secretKey;

    private $bucket;

    private $domain;

    public function __construct()
    {
        $qiniu = Config::get('qiniu');
        $this->accessKey = $qiniu['access_key'];
        $this->secretKey = $qiniu['secret_key'];
        $this->bucket = $qiniu['bucket'];
        $this->domain = $qiniu['domain'];
    }

    public function getToken()
    {
        $auth = new Auth($this->accessKey, $this->secretKey);
        $token = $auth->uploadToken($this->bucket, null, 60 * 60);
        $domain = $this->domain;

        return compact('token', 'domain');
    }

    public function uploadUrl($url)
    {
        $client = new Client(['timeout' => 120]);
        $response = $client->get($url);
        $token = $this->getToken()['token'];
        $uploader = new UploadManager();
        $result = $uploader->put($token, null, $response->getBody());

        if ($result[1]) {
            throw $result[1];
        }

        return $result[0]['key'];
    }
}
