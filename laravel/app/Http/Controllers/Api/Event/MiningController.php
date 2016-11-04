<?php

namespace App\Http\Controllers\Api\Event;

use Json;
use Illuminate\Http\Request;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class MiningController extends Controller
{
    public function getStart(Mining $mining, Request $request, $eventId)
    {
        if (! $mining->start($eventId, $request->userId)) {
            return Json::error('Not enough space available.', 401);
        }

        return Json::success();
    }
}
