<?php

namespace App\Library\Withdraw;

use Redis;
use Config;
use App\Models\{User, Wechat};
use EasyWeChat\Foundation\Application;

class Wechat
{
    public static function sendRedpack($userId, $openId, $gold): bool
    {
        $mchId = Config::get('wechat.mch_id');

        $options = [
            'payment' => [
                'merchant_id' => $mchId,
                'key' => Config::get('wechat.mch_key'),
            ],
        ];

        $luckyMoney = (new Application($options))->lucky_money;

        $luckyMoneyData = [
            'mch_billno' => $mchId.date('YmdHis').rand(1000, 9999),
            'send_name' => 'find',
            're_openid' => $openId,
            'total_num' => 1,
            'total_amount' => $gold * 100,
            'wishing' => '恭喜发财',
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'act_name' => '无',
            'remark' => '无',
        ];

        if ($luckyMoney->sendNormal($luckyMoneyData)) {
            User::where('id', $userId)->decrement('gold', $gold);
            Redis::hincrby('user:'.$userId, 'gold', -$gold);
        }

        return true;
    }

    public static function subscribe()
    {
        $wechat = Config::get('wechat');
        $options = [
            'debug'  => true,
            'app_id' => $wechat['app_id'],
            'secret' => $wechat['app_secret'],
            'token' => $wechat['token'],
            'aes_key' => '',
            'log' => [
                'level' => 'debug',
                'file' => $wechat['log'],
            ]
        ];

        $app = new Application($options);
        $server = $app->server;
        $userService = $app->user;

        $server->setMessageHandler(function($message) use ($userService) {
            $unionId = $userService->get($message->FromUserName)->openid;
            Wechat::addOne($message->FromUserName, $unionId);
        });

        $response = $server->serve();

        return $response;
    }
}
