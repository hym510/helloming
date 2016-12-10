<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentsController extends Controller
{
    protected function getXml($xml)
    {
        $equipment = [];
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $data = file_get_contents($path);
        $reader = new Reader();
        $reader->xml($data);
        $results = $reader->parse();
        foreach ($results['value'] as $key => $value) {
            $arr = [];
            $arr['key0'] = $value['value'][0]['value'];
            $arr['key1'] = $value['value'][1]['value'];
            $arr['key2'] = $value['value'][2]['value'];
            $arr['key3'] = $value['value'][3]['value'];
            $arr['key4'] = $value['value'][4]['value'];
            $arr['key5'] = $value['value'][5]['value'];
            $arr['key6'] = $value['value'][6]['value'];
            $equipment[] = $arr;
        }
        return $equipment;
    }

    public function postImportXml(Request $request)
    {
        $equipments = [];
        $xml = $request->xml->store('uploads');
        $equipments = $this->getXml($xml);
        foreach ($equipments as $equipment){
            $data = [];
            $data = ['name' => $equipment['key0'],
                'level' => $equipment['key1'],
                'max_level' => $equipment['key2'],
                'power' => $equipment['key3'],
                'job_id' => $equipment['key4'],
                'position' => $equipment['key5'],
                'upgrade' => $equipment['key6'],
            ];
            Equipment::create($data);
        }

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }

    public function getIndex()
    {
        $equipments = Equipment::when(request('keyword'), function ($q) {
            return $q->where('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.equipments.index', compact('equipments'));
    }
}
