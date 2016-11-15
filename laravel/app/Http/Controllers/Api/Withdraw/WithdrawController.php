<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use Redis;
use App\Library\Withdraw\Wechat;
use Illuminate\Routing\Controller;

class WithdrawController extends Controller
{
    public function getRedpack($gold)
    {
        if (Redis::hget('user:'.Auth::user()->user, 'gold') < $gold) {
            return Json::error('Gold are not enough.', 511);
        }

        $userId = Auth::user()->user;
        Wechat::sendRedpack($userId, Redis::hget('user:'.$userId, 'wechat_id'), $gold);

        return Json::success();
    }
}
