<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Event;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function getRefresh($count, $out)
    {
        return Json::success(Event::random(Auth::user()->user, $count));
    }
}
