<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use Redis;
use App\Models\User;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\ProfileRequest;

class ProfileController extends Controller
{
    public function getDetail()
    {
        return Json::success(Redis::hgetall('user:'.Auth::user()->user));
    }

    public function postUpdate(ProfileRequest $request)
    {
        return Json::success(User::updateProfile(Auth::user()->user, $request->input()));
    }
}
