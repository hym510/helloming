<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function getAll()
    {
        return Json::success(['events' => Event::all(Auth::user()->user)]);
    }

    public function postAdd(Request $request)
    {
        Event::addEvent(Auth::user()->user, $request->data);

        return Json::success();
    }

    public function postOpen(Request $request)
    {
        Event::addEvent(Auth::user()->user, $request->all());

        return Json::success();
    }

    public function getRefresh($count, $out)
    {
        return Json::success(Event::random(Auth::user()->user, $count));
    }
}
