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

    public function getEdit($monsterId)
    {
        $monster = Monster::findOrFail($monsterId);

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

    public function postUpdate(MonstersRequest $request, $monsterId)
    {
        Monster::where('id', $monsterId)->update($request->inputData());

        return redirect()->action('Admin\MonstersController@getIndex');
    }

    public function getDelete($monsterId)
    {
        Monster::where('id', $monsterId)->delete();

        return redirect()->action('Admin\MonstersController@getIndex');
    }
}
