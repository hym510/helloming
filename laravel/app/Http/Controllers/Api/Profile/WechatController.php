<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;

class WechatController extends Controller
{
    public function getBind($openid)
    {
        if (User::bindOpenid(Auth::user()->user, $openid)) {
            return Json::success();
        } else {
            return Json::error('An openid has bound to this account.', 216);
        }
    }
}
