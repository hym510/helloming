<?php

namespace App\Http\Controllers\Api\Data;

use Auth;
use Json;
use App\Models\Logger;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function getOnLine()
    {
        return Json::success(Logger::addOne(Auth::user()->user, 'online'));
    }
}
