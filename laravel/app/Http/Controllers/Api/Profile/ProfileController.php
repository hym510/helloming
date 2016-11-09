<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use Redis;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    public function getDetail()
    {
        return Json::success(Redis::hgetall('user:'.Auth::user()->user));
    }

    public function postUpdate(Request $request)
    {
        return Json::success(User::updateProfile($request->userId, $request->input()));
    }
}
