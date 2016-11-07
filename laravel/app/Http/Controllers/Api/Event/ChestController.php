<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Chest;
use Illuminate\Routing\Controller;

class ChestController extends Controller
{
    public function getOpen(Chest $chest, $eventId)
    {
        $success = $chest->open($eventId, Auth::user()->user);

        if (! $success) {
            return Json::error('Lack of material resources.', 501);
        }

        return Json::success($success);
    }
}
