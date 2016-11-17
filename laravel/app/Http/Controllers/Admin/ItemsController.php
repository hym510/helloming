<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ItemRequest;

class ItemsController extends Controller
{
    public function getIndex()
    {
        $items = Item::when(request('keyword'), function ($q) {
            return $q->where('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.items.index', compact('items'));
    }

    public function getAdd()
    {
        return view('admin.items.edit');
    }

    public function getEdit($itemId)
    {
        $item = Item::findOrFail($itemId);

        return view('admin.items.edit', compact('item'));
    }

    public function postStore(ItemRequest $request)
    {
        Item::create($request->inputData());

        return redirect()->action('Admin\ItemsController@getIndex');
    }

    public function postUpdate(ItemRequest $request, $itemId)
    {
        Item::where('id', $itemId)->update($request->inputData());

        return redirect()->action('Admin\ItemsController@getIndex');
    }

    public function getDelete($itemId)
    {
        Item::findOrFail($itemId)->delete();

        return redirect()->action('Admin\ItemsController@getIndex');
    }
}
