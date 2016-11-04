<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\UserItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BackpackController extends Controller
{
    public function getTool(Request $request)
    {
        return Json::success(UserItem::getAll($request->userId, 'tool'));
    }
}
