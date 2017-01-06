<?php

namespace App\Http\Controllers\Api\Shop;

use Json;
use App\Models\Diamond;
use Illuminate\Routing\Controller;

class DiamondController extends Controller
{
    public function getDiamond()
    {
        return Json::success(['diamond' => Diamond::all()->toArray()]);
    }
}
