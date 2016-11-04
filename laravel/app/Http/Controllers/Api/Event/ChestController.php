<?php

namespace App\Http\Controllers\Api\Event;

use Json;
use Illuminate\Http\Request;
use App\Library\Event\Chest;
use Illuminate\Routing\Controller;

class ChestController extends Controller
{
    public function getOpen(Chest $chest, Request $request, $eventId)
    {
        $success = $chest->open($eventId, $request->userId);

        if (! $success) {
            return Json::error('Lack of material resources.', 501);
        }

        return Json::success($success);
    }
}
