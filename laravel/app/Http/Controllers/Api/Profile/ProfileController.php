<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use Redis;
use App\Models\{Job, User};
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\ProfileRequest;

class ProfileController extends Controller
{
    public function getDetail()
    {
        $profile = Redis::hgetall('user:'.Auth::user()->user);
        $profile['job'] = Job::where('id', $profile['job_id'])->first(['name'])->name;
        $profile['next_level_exp'] = json_decode(Redis::get('level_attributes'))[$profile['level'] - 1]->exp;

        return Json::success($profile);
    }

    public function postUpdate(ProfileRequest $request)
    {
        return Json::success(User::updateProfile(Auth::user()->user, $request->input()));
    }
}
