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
        $levels = ReadXml::readDatabase($path);
        foreach ($levels as $level){
            $data = [
                'level' => $level['id_i'],
                'exp' => $level['exp_i'],
                'power' => $level['power_i'],
                'action' => $level['action_i'],
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
