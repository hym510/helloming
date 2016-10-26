<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\UserItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackpackController extends Controller
{
    public function getTool(Request $request)
    {
        return Json::success(UserItem::getAll($request->userId, 'tool'));
    }
}
