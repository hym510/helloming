<?php

namespace App\Http\Controllers\Api\Withdraw;

use Auth;
use Json;
use App\Models\User;
use App\Library\Redis\Redis;
use App\Library\Smser\Smser;
use Illuminate\Http\Request;
use App\Library\Withdraw\Withdraw;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\{RedpackRequest, WithdrawRequest, WithdrawPwdRequest};

class WithdrawController extends Controller
{
    public function postSms(Smser $smser, Request $request)
    {
        if ($smser->requestSmsCode($request->phone)) {
            return Json::success();
        } else {
            return Json::error('Fails to send message.', 602);
        }
    }

    public function postPassword(WithdrawRequest $request)
    {
        User::withdraw(Auth::user()->user, $request->password);

        return Json::success();
    }

    public function postUpdatePwd(WithdrawPwdRequest $request)
    {
        if (! getenv('APP_DEBUG') && ! $smser->verifySmsCode($request->phone, $request->code)) {
            return Json::error('Invalid SMS code.', 603);
        }

        User::withdraw(Auth::user()->user, $request->password);

        return Json::success();
    }

    public function postRedpack(RedpackRequest $request)
    {
        $user = Redis::hmget('user:'.Auth::user()->user, 'gold', 'withdraw_password');

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
