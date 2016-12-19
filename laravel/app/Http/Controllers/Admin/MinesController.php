<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mine;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MinesRequest;

class MinesController extends Controller
{
    public function getIndex()
    {
        $mines = Mine::paginate()->appends(request()->all());

        return view('admin.mines.index', compact('mines'));
    }

    public function postImportXml(Request $request)
    {
        Mine::truncate();
        $xml = $request->xml->storeAs('uploads', 'mine.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $mines = ReadXml::readDatabase($path);

        foreach ($mines as $mine) {
            $data = [

            ];

            Mine::create($data);
        }

        return redirect()->action('Admin\MinesController@getIndex');
    }
}
