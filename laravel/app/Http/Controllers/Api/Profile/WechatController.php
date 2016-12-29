<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\{UnbindRequest, WechatRequest};

class WechatController extends Controller
{
    public function postBind(WechatRequest $request)
    {
        $bound = User::bindUnionid(
            Auth::user()->user, $request->unionid
        );

        if ($bound) {
            return Json::success();
        } else {
            return Json::error('An unionid has bound to this account.', 216);
        }
    }

    public function getUnbind(UnbindRequest $request)
    {
        $success = User::unbindUnionid(Auth::user()->user, $request->password);

        if ($success) {
            return Json::success();
        } else {
            return Json::error('Password mismatch.', 210);
        }
    }
}
