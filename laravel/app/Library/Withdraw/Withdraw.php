<?php

namespace App\Library\Withdraw;

use Redis;
use Config;
use App\Models\{User, Wechat};
use EasyWeChat\Foundation\Application;

class Withdraw
{
    public static function sendRedpack($userId, $amount): bool
    {
        $wechat = Config::get('wechat');
        $options = [
            'app_id' => $wechat['app_id'],
            'payment' => [
                'merchant_id' => $wechat['mch_id'],
                'key' => $wechat['mch_key'],
                'cert_path' => $wechat['cert_path'],
                'key_path' => $wechat['key_path'],
                'log' => [
                    'level' => 'debug',
                    'file' => $wechat['log'],
                ]
            ],
        ];

        $unionId = Redis::hget('user:'.$userId, 'wechat_id');

        $openId = Wechat::getKeyValue(
            [['union_id', $unionId]], ['open_id']
        );

        $goldExchange = json_decode(Redis::get('gold_exchange'));
        $amount = $amount * $goldExchange['money'] / $goldExchange['money'];
        $luckyMoney = (new Application($options))->lucky_money;
        $luckyMoneyData = [
            'mch_billno' => $wechat['mch_id'] . date('YmdHis') . rand(1000, 9999),
            'send_name' => 'find',
            're_openid' => $openId,
            'total_num' => 1,
            'total_amount' => $amount * 100,
            'wishing' => '恭喜发财',
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'act_name' => '无',
            'remark' => '无',
        ];

        if ($luckyMoney->sendNormal($luckyMoneyData)) {
            User::where('id', $userId)->decrement('gold', $amount * 10);
            Redis::hincrby('user:'.$userId, 'gold', -$amount);
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
            'aes_key' => $wechat['aes_key'],
            'log' => [
                'level' => 'debug',
                'file' => $wechat['log'],
            ]
        ];

        $app = new Application($options);
        $server = $app->server;
        $userService = $app->user;

        $server->setMessageHandler(function($message) use ($userService) {
            Wechat::addOne(
                $message->FromUserName,
                $userService->get($message->FromUserName)->unionid
            );
        });

        return $server;
    }
}
