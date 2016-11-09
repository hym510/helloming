<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShopRequest;

class ShopController extends Controller
{
    public function getIndex()
    {
        $shops = Shop::when(request('keyword'), function ($q) {
            return $q->where('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.shop.index', compact('shops'));
    }

    public function getAdd()
    {
        return view('admin.shop.edit');
    }

    public function getEdit($id)
    {
        $shop = Shop::findOrFail($id);

        return view('admin.shop.edit', compact('shop'));
    }

    public function postUpdate(ShopRequest $request, $id)
    {
        $data = $request->inputData();
        $shop = Shop::findOrFail($id);
        $shop->update($data);

        return redirect()->action('Admin\ShopController@getIndex');
    }

    public function postStore(ShopRequest $request)
    {
        $data = $request->inputData();
        Shop::create($data);

        return redirect()->action('Admin\ShopController@getIndex');
    }

    public function getDelete($id)
    {
        Shop::findOrFail($id)->delete();

        return redirect()->action('Admin\ShopController@getIndex');
    }
}
