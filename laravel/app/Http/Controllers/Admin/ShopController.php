<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function getIndex()
    {
        return view('admin.shop.index', ['shops' => Shop::get()]);
    }

    public function postImportXml(Request $request)
    {
        $shops = [];
        Shop::truncate();
        $xml = $request->xml->storeAs('uploads', 'shop.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $shops = ReadXml::readDatabase($path);
        foreach ($shops as $shop){
            $data = [
                'item_id' => $shop['item_i'],
                'type'  => $shop['type_i'],
                'price' => $shop['price_i'],
                'quantity' => $shop['quantity_i'],
            ];
            Shop::create($data);
        }

        return redirect()->action('Admin\ShopController@getIndex');
    }

}
