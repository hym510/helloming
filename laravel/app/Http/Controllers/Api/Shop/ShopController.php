<?php

namespace App\Http\Controllers\Api\Shop;

use Json;
use App\Models\Shop;
use Illuminate\Routing\Controller;

class ShopController extends Controller
{
    public function getGoods()
    {
        return Json::success(Shop::all()->toArray());
    }
}
