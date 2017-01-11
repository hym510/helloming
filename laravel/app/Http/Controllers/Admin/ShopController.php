<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;

class ShopController extends Controller
{
    public function getIndex()
    {
        return view('admin.shop.index', ['shops' => Shop::get()]);
    }
}
