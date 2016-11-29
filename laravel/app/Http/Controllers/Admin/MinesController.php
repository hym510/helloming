<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mine;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MinesRequest;

class MinesController extends Controller
{
    public function getIndex()
    {
        $mines = Mine::when(request('keyword'), function ($q) {
            return $q->where('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.mines.index', compact('mines'));
    }

    public function getAdd()
    {
        return view('admin.mines.edit');
    }

    public function getEdit($mineId)
    {
        return view('admin.mines.edit', [
            'mine' => Mine::findOrFail($mineId)
        ]);
    }

    public function postStore(MinesRequest $request)
    {
        Mine::create($request->inputData());

        return redirect()->action('Admin\MinesController@getIndex');
    }

    public function postUpdate(MinesRequest $request, $mineId)
    {
        Mine::where('id', $mineId)->update($request->inputData());

        return redirect()->action('Admin\MinesController@getIndex');
    }

    public function getDelete($mineId)
    {
        Mine::where('id', $mineId)->delete();

        return redirect()->action('Admin\MinesController@getIndex');
    }
}
