<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use Illuminate\Routing\Controller;
use App\Library\Event\MonsterEvent;
use App\Http\Requests\Api\MonsterRequest;

class MonsterController extends Controller
{
    public function postAtk(MonsterRequest $request)
    {
        $success = MonsterEvent::atk($request->event_id, $request->atk, Auth::user()->user);

        if (! $success) {
            return Json::error('Lack of physical strength.', 501);
        }

        return Json::success($success);
    }
}
