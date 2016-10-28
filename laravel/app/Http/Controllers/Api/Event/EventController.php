<?php

namespace App\Http\Controllers\Api\Event;

use App\Models\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getIndex()
    {
        return Json::success(Event::random());
    }
}
