<?php

namespace App\Http\Controllers\Api\Withdraw;

use Auth;
use Json;
use Redis;
use App\Models\User;
use App\Library\Withdraw\Withdraw;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\{RedpackRequest, WithdrawRequest};

class WithdrawController extends Controller
{
    public function postPassword(WithdrawRequest $request)
    {
        User::withdraw(Auth::user()->user, $request->password);

        return Json::success();
    }

    public function postRedpack(RedpackRequest $request)
    {
        $user = Redis::hget('user:'.Auth::user()->user, 'gold', 'withdraw_password');

        if (! password_verify($request->password, $user[1])) {
            return Json::error('Password mismatch.', 210);
        }

        if ($user[0] < $request->gold) {
            return Json::error('Gold are not enough.', 511);
        }

        Withdraw::sendRedpack(Auth::user()->user, $request->gold, $request->password);

        return Json::success();
    }
}
