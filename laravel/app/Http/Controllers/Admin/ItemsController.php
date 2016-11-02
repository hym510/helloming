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

    public function getEdit($id)
    {
        $item = Item::findOrFail($id);

        return view('admin.items.edit', compact('item'));
    }

    public function postStore(ItemRequest $request)
    {
        $item = $request->inputData();
        Item::create($item);

        return redirect()->action('Admin\ItemsController@getIndex');
    }

    public function postUpdate(ItemRequest $request, $id)
    {
        $data = $request->inputData();
        $item = Item::findOrFail($id);
        $item->update($data);

        return redirect()->action('Admin\ItemsController@getIndex');
    }

    public function getDelete($id)
    {
        Item::findOrFail($id)->delete();

        return redirect()->action('Admin\ItemsController@getIndex');
    }
}
