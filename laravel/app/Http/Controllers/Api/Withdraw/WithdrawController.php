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
        Wechat::sendRedpack(Redis::hget('user:'.Auth::user()->user, 'wechat_id'), $gold);

        return Json::success();
    }
}
