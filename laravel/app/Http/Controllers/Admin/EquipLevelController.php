<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipLevelController extends Controller
{
    public function getIndex()
    {
        return view('admin.equiplevel.index');
    }

    public function postImportXml(Request $request)
    {
        $xml = $request->xml->storeAs('uploads', 'equipRating.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $equiplevels = ReadXml::readDatabase($path);

        foreach ($equiplevels as $equiplevel){
            $data = [
                'level' => $equiplevel['level_i'],
                'icon' => $equiplevel['icon_i'],
            ];
            $all[] = $data;
        }

        Redis::set('expense', json_encode($all));

        return $this->backSuccessMsg('成功添加xml文件');
    }
}
