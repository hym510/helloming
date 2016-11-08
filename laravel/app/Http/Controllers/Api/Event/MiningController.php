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
        $success = $mining->start($eventId, Auth::user()->user);

        if (! $success) {
            return Json::error('Not enough space available.', 401);
        }

        return Json::success($success);
    }

    public function getComplete(Mining $mining, $hostMiningId)
    {
        $success = $mining->complete($hostMiningId, Auth::user()->user);

        if (! $success) {
            return Json::error('Diamonds are not enough.', 601);
        }

        return Json::success($success);
    }
}
