<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use Redis;
use App\Library\Profile\Equip;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\ProfileRequest;
use App\Models\{Job, LevelAttr, StateAttr, User};

class ProfileController extends Controller
{
    public function getDetail()
    {
        $profile = Redis::hgetall('user:'.Auth::user()->user);
        $profile['job'] = Job::where('id', $profile['job_id'])->first(['name'])->name;
        $profile['next_level_exp'] = LevelAttr::where('level', $profile['level'] + 1)->first('exp')->exp;
        $profile['next_state_power'] = StateAttr::where('level', $profile['state'] + 1)->first('power')->power;
        $profile['pos1_upgrade'] = Equip::material($profile['job_id'], $profile['equipment1_level'], 1);
        $profile['pos2_upgrade'] = Equip::material($profile['job_id'], $profile['equipment2_level'], 2);
        $profile['pos3_upgrade'] = Equip::material($profile['job_id'], $profile['equipment3_level'], 3);

        return Json::success($profile);
    }

    public function postUpdate(ProfileRequest $request)
    {
        return Json::success(User::updateProfile(Auth::user()->user, $request->input()));
    }
}
