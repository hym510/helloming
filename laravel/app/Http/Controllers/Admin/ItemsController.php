<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Library\Excel\ReadExcel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ItemRequest;

class ItemsController extends Controller
{
    public function postImportExcel(Item $item, Request $request)
    {
        $items = Item::get();
        $path = $request->excel->path();

        $excels = ReadExcel::getExcel($path);
        foreach ($excels as $excel){
            foreach ($excel as $value){

            }
        }

    }

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
        return view('admin.items.edit',
            ['item' => Item::findOrFail($itemId)]
        );
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
        Item::where('id', $itemId)->delete();

        return redirect()->action('Admin\ItemsController@getIndex');
    }
}
