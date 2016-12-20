<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class MiningController extends Controller
{
    public function getStart($eventId)
    {
        if (! Mining::start($eventId, Auth::user()->user)) {
            return Json::error('Not enough space available.', 401);
        }

        return Json::success();
    }

    public function getComplete($hostEventId)
    {
        $success = Mining::complete($hostEventId, Auth::user()->user);

        if (! $success) {
            return Json::error('Diamonds are not enough.', 601);
        }

        return Json::success($success);
    }
}
