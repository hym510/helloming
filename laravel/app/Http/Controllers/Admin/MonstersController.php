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
        $monsters = ReadXml::readDatabase($path);
        foreach ($monsters as $monster){
            $data = [
                'name' => $monster['name_s'],
                'level' => $monster['level_i'],
                'hp' => $monster['hp_i'],
            ];
            Monster::create($data);
        }

        return redirect()->action('Admin\MonstersController@getIndex');
    }
}
