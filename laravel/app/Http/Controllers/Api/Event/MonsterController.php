<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Monster;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\MonsterRequest;

class MonsterController extends Controller
{
    public function postAtk(MonsterRequest $request)
    {
        $success = Monster::atk($request->event_id, $request->atk, Auth::user()->user);

        if (! $success) {
            return Json::error('Lack of physical strength.', 501);
        }

        return Json::success($success);
    }
}
