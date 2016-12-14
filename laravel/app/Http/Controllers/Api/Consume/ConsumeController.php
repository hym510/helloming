<?php

namespace App\Http\Controllers\Api\Consume;

use Auth;
use Json;
use App\Models\User;
use Illuminate\Routing\Controller;

class ConsumeController extends Controller
{
    public function getShoes($shoes)
    {
        if (User::consumeShoes(Auth::user()->user, $shoes)) {
            return Json::success();
        } else {
            return Json::error('Shoes are not enough.', 701);
        }
    }
}
