<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Shop;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function getIndex()
    {
        $shops = Shop::get();

        return view('admin.shop.index', compact('shops'));
    }

    public function getAdd(Item $item)
    {
        $items = $item->get();

        return view('admin.shop.add', compact('items'));
    }

    public function postStore($id,  Shop $shop)
    {
        $item = Item::findOrFail($id);
        $shop['item_id'] = $item['id'];
        $shop['type'] = $item['type'];
        $shop['priority'] = $item['priority'];
        $shop->save();

        return redirect()->action('Admin\ShopController@getIndex');
    }

    public function getSetPrice($id, $value)
    {
        if (is_numeric($value)) {
            $price = Shop::findOrFail($id);
            $price->price = floor($value);
            $price->save();
        } else {
            return response()->json(['message' => 403]);
        }
    }

    public function getDelete($id)
    {
        Shop::findOrFail($id)->delete();

        return redirect()->action('Admin\ShopController@getIndex');
    }
}
