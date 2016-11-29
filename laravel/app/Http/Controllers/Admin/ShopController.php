<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Item, Shop};
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function getIndex()
    {
        return view('admin.shop.index', ['shops' => Shop::get()]);
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
            Shop::where('id', $id)->update(['price' => floor($value)]);
        } else {
            return Json::error('Fails to set price.', 403);
        }
    }

    public function getDelete($id)
    {
        Shop::where('id', $id)->delete();

        return redirect()->action('Admin\ShopController@getIndex');
    }
}
