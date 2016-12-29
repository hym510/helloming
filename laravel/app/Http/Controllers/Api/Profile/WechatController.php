<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\WechatRequest;

class WechatController extends Controller
{
    public function postBind(WechatRequest $request)
    {
        $bound = User::bindOpenid(
            Auth::user()->user, $request->openid, $request->withdraw_password
        );

        if ($bound) {
            return Json::success();
        } else {
            return Json::error('An openid has bound to this account.', 216);
        }
    }

    public function getUnbind()
    {
        return Json::success(User::unbindOpenid(Auth::user()->user));
    }
}
