<?php

namespace App\Http\Controllers\Api\Auth;

use Json;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function postLogin()
    {
        return Json::success();
    }
}
