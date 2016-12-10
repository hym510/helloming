<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Models\LevelAttr;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function getIndex()
    {
        return view('admin.levels.index',
            ['levels' => LevelAttr::orderBy('level', 'asc')->get()]
        );
    }

    public function postImportXml(Request $request)
    {
        levelAttr::truncate();
        $xml = $request->xml->store('uploads');
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $db = ReadXml::readDatabase($path);
        foreach ($db as $k=>$v){
            $data = [
                'level' => $v['id_i'],
                'exp' => $v['exp_i'],
                'power' => $v['power_i'],
                'action' => $v['action_i'],
            ];
            levelAttr::create($data);
        }

        return redirect()->action('Admin\LevelController@getIndex');
    }

    protected function updateCache()
    {
        Redis::set('level_attributes',
            json_encode(LevelAttr::orderBy('level', 'asc')->get()->toArray())
        );
    }
}
