<?php

namespace App\Http\Controllers\Api\Event;

use Json;
use Redis;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getIndex(Request $request)
    {
        return Json::success(Event::random(
            Redis::hget('user:'.$request->userId, 'level')
        ));
    }
}
