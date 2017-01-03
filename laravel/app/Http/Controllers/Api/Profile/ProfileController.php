<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use App\Library\Redis\Redis;
use App\Library\Profile\Equip;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\ProfileRequest;
use App\Models\{Job, LevelAttr, StateAttr, User};

class ProfileController extends Controller
{
    public function getDetail()
    {
        $profile = Redis::hgetall('user:'.Auth::user()->user);

        return Json::success($profile);
    }

    public function postUpdate(ProfileRequest $request)
    {
        return Json::success(User::updateProfile(Auth::user()->user, $request->input()));
    }
}
