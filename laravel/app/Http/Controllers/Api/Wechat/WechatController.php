<?php

namespace App\Http\Controllers\Api\Wechat;

use App\Library\Withdraw\Withdraw;
use Illuminate\Routing\Controller;

class WechatController extends Controller
{
    public function getSubscribe()
    {
        $wechat = Config::get('wechat');
        $token = $wechat['token'];
        $echoStr = $_GET['echostr'];
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];

        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            echo $echoStr;
            exit;
        } else {
            return false;
        }
    }

    public function postSubscribe()
    {
        $server = Withdraw::subscribe();

        return $server->serve();
    }
}
