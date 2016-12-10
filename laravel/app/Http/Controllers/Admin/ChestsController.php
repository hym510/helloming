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
        $xml = $request->xml->store('uploads');
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $chests = ReadXml::readDatabase($path);
        foreach ($chests as $chest){
            $data = [

            ];

        Chest::create($data);
        }

        return redirect()->action('Admin\ChestsController@getIndex');
    }
}
