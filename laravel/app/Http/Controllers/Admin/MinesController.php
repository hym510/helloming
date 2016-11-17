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

    public function getEdit($id)
    {
        $mine = Mine::findOrFail($id);

        return view('admin.mines.edit', compact('mine'));
    }

    public function postStore(MinesRequest $request)
    {
        $mine = $request->inputData();
        Mine::create($mine);

        return redirect()->action('Admin\MinesController@getIndex');
    }

    public function postUpdate(MinesRequest $request, $id)
    {
        $mine = Mine::findOrFail($id);
        $mine->update($request->inputData());

        return redirect()->action('Admin\MinesController@getIndex');
    }

    public function getDelete($id)
    {
        Mine::findOrFail($id)->delete();

        return redirect()->action('Admin\MinesController@getIndex');
    }
}
