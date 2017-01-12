<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Models\HostEvent;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class HostController extends Controller
{
    public function getEvents()
    {
        return Json::success([
            'host_events' => HostEvent::getHost(Auth::user()->user)
        ]);
    }

    public function getPrize($hostEventId)
    {
        return Json::success(Mining::prize(Auth::user()->user, $hostEventId));
    }
}
