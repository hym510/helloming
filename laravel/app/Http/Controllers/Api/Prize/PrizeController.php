<?php

namespace App\Http\Controllers\Api\Prize;

use Auth;
use Json;
use App\Library\Prize\Prize;
use Illuminate\Routing\Controller;

class PrizeController extends Controller
{
    public function getPower()
    {
        Prize::power(Auth::user()->user);

        return Json::success();
    }
}
