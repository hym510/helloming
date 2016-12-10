<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function getIndex()
    {
        $items = Item::paginate()->appends(request()->all());

        return view('admin.items.index', compact('items'));
    }

    public function postImportXml(Request $request)
    {
        Item::truncate();
        $xml = $request->xml->store('uploads');
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $items = ReadXml::readDatabase($path);
        foreach ($items as $item){
            $data = [
                'id' => $item['id_i'],
            ];
            Item::create($data);
        }

        return redirect()->action('Admin\ItemsController@getIndex');
    }
}
