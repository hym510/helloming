<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Http\Controllers\Admin\Controller;

class ShopController extends Controller
{
    public function getIndex()
    {
        return view('admin.shop.index', ['shops' => Shop::get()]);
    }
}
