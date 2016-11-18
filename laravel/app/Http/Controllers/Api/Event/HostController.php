<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class HostController extends Controller
{
    public function getMine()
    {
        return Json::success(Mining::host(Auth::user()->user));
    }

    public function getPrize()
    {
        return Json::success(Mining::prize(Auth::user()->user));
    }
}
