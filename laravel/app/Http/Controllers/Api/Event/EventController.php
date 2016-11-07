<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Event;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function getRefresh(Event $event)
    {
        return Json::success($event->random(Auth::user()->user));
    }
}
