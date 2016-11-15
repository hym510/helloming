<?php

namespace App\Library\Withdraw;

use Config;
use App\Models\User;
use EasyWeChat\Foundation\Application;

class Wechat
{
    public static function sendRedpack($openId, $gold): bool
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

        return $luckyMoney->sendNormal($luckyMoneyData);
    }
}
