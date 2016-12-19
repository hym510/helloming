<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chest;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChestsController extends Controller
{
    public function getIndex()
    {
        return view('admin.chests.index', ['chests' => Chest::get()]);
    }

    public function postImportXml(Request $request)
    {
        Chest::truncate();
        $xml = $request->xml->storeAs('uploads', 'chest.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $chests = ReadXml::readDatabase($path);

        foreach ($chests as $chest) {
            $data = [
                'item_id' => chest['finishItem_i'],
                'cost' => chest['finishItemQuantity_i'],
            ];

            Chest::create($data);
        }

        return redirect()->action('Admin\ChestsController@getIndex');
    }
}
