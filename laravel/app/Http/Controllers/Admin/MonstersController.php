<?php

namespace App\Http\Controllers\Admin;

use App\Models\Monster;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MonstersRequest;

class MonstersController extends Controller
{
    public function getIndex()
    {
        $monsters = Monster::when(request('keyword'), function ($q) {
            return $q->where('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.monsters.index', compact('monsters'));
    }

    public function getAdd()
    {
        return view('admin.monsters.edit');
    }

    public function getEdit($id)
    {
        $monster = Monster::findOrFail($id);

        return view('admin.monsters.edit', compact('monster'));
    }

    public function postStore(MonstersRequest $request)
    {
        $data = $request->inputData();
        if ($data['kill_limit'] == '0') {
            unset($data['kill_limit_time']);
        }
        Monster::create($data);

        return redirect()->action('Admin\MonstersController@getIndex');
    }

    public function postUpdate(MonstersRequest $request, $id)
    {
        $data = $request->inputData();
        $monster = Monster::findOrFail($id);
        $monster->update($data);

        return redirect()->action('Admin\MonstersController@getIndex');
    }

    public function getDelete($id)
    {
        Monster::findOrFail($id)->delete();

        return redirect()->action('Admin\MonstersController@getIndex');
    }
}
