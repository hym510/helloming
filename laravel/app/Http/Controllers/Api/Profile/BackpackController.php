<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\UserItem;
use App\Http\Controllers\Controller;

class BackpackController extends Controller
{
    public function getItem(Request $request)
    {
        return Json::success(User::getProfile($request->userId));
    }

    public function postUpdate(Request $request)
    {
        return Json::success(User::updateProfile($request->userId, $request->input()));
    }
}
