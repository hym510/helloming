<?php

namespace App\Http\Controllers\Api\Replenish;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;

class ReplenishController extends Controller
{
    public function getAction($gold)
    {
        if (User::ReplenishAction(Auth::user()->user, $gold)) {
            return Json::success();
        } else {
            return Json::error('Gold are not enough.', 511);
        }
    }

    public function getPower($diamonds)
    {
        if (User::ReplenishPower(Auth::user()->user, $diamonds)) {
            return Json::success();
        } else {
            return Json::error('Diamonds are not enough.', 601);
        }
    }
}
