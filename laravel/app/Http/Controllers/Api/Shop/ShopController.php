<?php

namespace App\Http\Controllers\Api\Shop;

use Json;
use App\Models\{Shop, Order};
use Illuminate\Routing\Controller;

class ShopController extends Controller
{
    public function getGoods()
    {
        return Json::success(['goods' => Shop::all()->toArray()]);
    }

    public function postOrder(OrderRequest $request)
    {
        return Json::success(Order::createOrder($request->input()));
    }
}
