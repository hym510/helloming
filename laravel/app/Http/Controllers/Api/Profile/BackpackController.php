<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use App\Models\UserItem;
use Illuminate\Routing\Controller;

class BackpackController extends Controller
{
    public function getTool()
    {
        return Json::success(UserItem::getAll(Auth::user()->user, 'tool'));
    }
}
