<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class HostController extends Controller
{
    public function getMine(Mining $mining)
    {
        return Json::success($mining->host(Auth::user()->user));
    }
}
