<?php

namespace App\Http\Controllers\Api\Event;

use Json;
use Illuminate\Http\Request;
use App\Library\Event\Monster;
use Illuminate\Routing\Controller;

class MonsterController extends Controller
{
    public function getAtk(Monster $monster, Request $request, $eventId, $atk)
    {
        $success = $monster->atk($eventId, $atk, $request->userId);

        if (! $success) {
            return Json::error('Lack of physical strength.', 501);
        }

        return Json::success($success);
    }
}
