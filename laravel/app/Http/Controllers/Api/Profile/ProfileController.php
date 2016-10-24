<?php

namespace App\Http\Controllers\Api\Profile;

use Json;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function getDetail(Request $request)
    {
        return Json::success(User::getProfile($request->userId));
    }
}
