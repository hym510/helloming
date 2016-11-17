<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChestsRequest;

class ChestsController extends Controller
{
    public function getIndex()
    {
        $chests = Chest::when(request('keyword'), function ($q) {
            return $q->where('id', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.chests.index', compact('chests'));
    }

    public function getAdd()
    {
        return view('admin.chests.edit');
    }

    public function getEdit($id)
    {
        $chest = Chest::findOrFail($id);

        return view('admin.chests.edit', compact('chest'));
    }

    public function postStore(ChestsRequest $request)
    {
        Chest::create($request->inputData());

        return redirect()->action('Admin\ChestsController@getIndex');
    }

    public function postUpdate(ChestsRequest $request, $id)
    {
        $chest = Chest::findOrFail($id);
        $chest->update($request->inputData());

        return redirect()->action('Admin\ChestsController@getIndex');
    }

    public function getDelete($id)
    {
        Chest::findOrFail($id)->delete();

        return redirect()->action('Admin\ChestsController@getIndex');
    }
}
