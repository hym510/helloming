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
        $bound = User::bindUnionid(
            Auth::user()->user, $request->unionid, $request->withdraw_password
        );

        if ($bound) {
            return Json::success();
        } else {
            return Json::error('An unionid has bound to this account.', 216);
        }
    }

    public function getUnbind()
    {
        return Json::success(User::unbindUnionid(Auth::user()->user));
    }
}
