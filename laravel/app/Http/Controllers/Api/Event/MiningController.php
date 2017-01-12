<?php

namespace App\Http\Controllers\Api\Event;

use Auth;
use Json;
use App\Library\Event\Mining;
use Illuminate\Routing\Controller;

class MiningController extends Controller
{
    public function getStart($hostEventId)
    {
        $success = Mining::start($hostEventId, Auth::user()->user);

        if (! $success) {
            return Json::error('Not enough space available.', 401);
        }

        return Json::success();
    }

    public function getComplete($hostEventId)
    {
        switch (Mining::complete($hostEventId, Auth::user()->user)) {
            case 'finish':
                return Json::success();
            case 'lack':
                return Json::error('Diamonds are not enough.', 601);
            case 'nonexist':
                return Json::success();
            case 'prize':
                return Json::success();
        }
    }
}
