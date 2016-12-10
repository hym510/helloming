<?php

namespace App\Http\Controllers\Admin;

use App\Models\Monster;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonstersController extends Controller
{
    public function getIndex()
    {
        $monsters = Monster::paginate();

        return view('admin.monsters.index', compact('monsters'));
    }

    public function postImportXml(Request $request)
    {
        Monster::truncate();
        $xml = $request->xml->store('uploads');
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $db = ReadXml::readDatabase($path);
        foreach ($db as $monster){
            $data = [
                            ];
            Monster::create($data);
        }

        return redirect()->action('Admin\MonstersController@getIndex');
    }
}
