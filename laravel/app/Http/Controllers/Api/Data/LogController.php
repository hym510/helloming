<?php

namespace App\Http\Controllers\Api\Data;

use Auth;
use Json;
use App\Models\Logger;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.api');
    }

    public function getOnLine()
    {
        return Json::success(Logger::addOne(Auth::user()->user, 'online'));
    }

    public function getOffLine()
    {
        return Json::success(Logger::addOne(Auth::user()->user, 'offline'));
    }
}
