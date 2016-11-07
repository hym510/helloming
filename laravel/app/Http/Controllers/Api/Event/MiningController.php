<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class MiningController extends Controller
{
    public function getStart(Mining $mining, $eventId)
    {
        if (! $mining->start($eventId, Auth::user()->user)) {
            return Json::error('Not enough space available.', 401);
        }

        return Json::success();
    }
}
