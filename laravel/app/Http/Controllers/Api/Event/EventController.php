<?php

namespace App\Http\Controllers\Api\Event;

use Json;
use App\Library\Event\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function getRefresh(Event $event, Request $request)
    {
        return Json::success($event->random($request->userId));
    }
}
