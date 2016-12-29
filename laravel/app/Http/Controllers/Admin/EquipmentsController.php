<?php

namespace App\Http\Controllers\Admin;

use Json;
use App\Models\Equipment;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentsController extends Controller
{
    public function getIndex()
    {
        $equipments = Equipment::paginate()->appends(request()->all());

        return view('admin.equipments.index', compact('equipments'));
    }

    public function postImportXml(Request $request)
    {
        Equipment::truncate();
        $xml = $request->xml->storeAs('uploads', 'equip.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $equipments = ReadXml::readDatabase($path);

        foreach ($equipments as $equipment) {
            $data = [
                'id' => $equipment['id_i'],
                'name' => $equipment['name_s'],
                'level'  => $equipment['level_i'],
                'max_level' => $equipment['maxLevel_i'],
                'power' => $equipment['power_i'],
                'job_id' => $equipment['career_i'],
                'position' => $equipment['position_i'],
                'upgrade' => $equipment['upgrade_a'],
            ];

            Equipment::create($data);
        }

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }

    public function postImportImg(Request $request)
    {
        Json::success(app('qiniu')->uploadUrl());

        return $this->backSuccessMsg('上传成功');
    }
}
