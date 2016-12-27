<?php

namespace App\Http\Controllers\Api\Withdraw;

use Auth;
use Json;
use Redis;
use App\Library\Withdraw\Withdraw;
use Illuminate\Routing\Controller;

class WithdrawController extends Controller
{
    public function getRedpack($gold)
    {
        if (Redis::hget('user:'.Auth::user()->user, 'gold') < $gold) {
            return Json::error('Gold are not enough.', 511);
        }

        Withdraw::sendRedpack(Auth::user()->user, $gold);

        return Json::success();
    }
}
