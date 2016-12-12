<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Models\StateAttr;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    protected function updateCache()
    {
        Redis::set('state_attributes',
            json_encode(StateAttr::orderBy('level', 'asc')->get(['power'])->toArray())
        );
    }

    public function getIndex()
    {
        $states = StateAttr::paginate()->appends(request()->all());

        return view('admin.state.index', compact('states'));
    }

    public function postImportXml(Request $request)
    {
        StateAttr::truncate();
        $xml = $request->xml->storeAs('uploads', 'state.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $states = ReadXml::readDatabase($path);
        foreach ($states as $state){
            $data = [

            ];

            StateAttr::create($data);
        }

        return redirect()->action('Admin\StateController@getIndex');
    }

}
