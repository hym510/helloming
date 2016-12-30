<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function postAdd(Request $request)
    {
        Event::addEvent(Auth::user()->user, $request->event_id, $request->longitude, $request->latitude);

        return Json::success();
    }

    public function getRefresh($count, $out)
    {
        return Json::success(Event::random(Auth::user()->user, $count));
    }
}
