<?php

namespace App\Http\Controllers\Api\Replenish;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;

class ReplenishController extends Controller
{
    public function getPower($diamonds)
    {
        if (User::ReplenishPower(Auth::user()->user, $diamonds)) {
            return Json::success();
        } else {
            return Json::error('Diamonds are not enough.', 601);
        }
    }
}
