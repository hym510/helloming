<?php

namespace App\Http\Controllers\Api\Replenish;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;

class ReplenishController extends Controller
{
    public function getAction($quantity)
    {
        if (User::ReplenishAction(Auth::user()->user, $quantity)) {
            return Json::success();
        } else {
            return Json::error('Currency are not enough.', 512);
        }
    }

    public function getPower($quantity)
    {
        if (User::ReplenishPower(Auth::user()->user, $quantity)) {
            return Json::success();
        } else {
            return Json::error('Currency are not enough.', 512);
        }
    }
}
