<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChestsRequest;

class ChestsController extends Controller
{
    public function getIndex()
    {
        $chests = Chest::get();

        return view('admin.chests.index', compact('chests'));
    }

    public function getAdd()
    {
        return view('admin.chests.edit');
    }

    public function getEdit($chestId)
    {
        $chest = Chest::findOrFail($chestId);

        return view('admin.chests.edit', compact('chest'));
    }

    public function postStore(ChestsRequest $request)
    {
        Chest::create($request->inputData());

        return redirect()->action('Admin\ChestsController@getIndex');
    }

    public function postUpdate(ChestsRequest $request, $chestId)
    {
        Chest::where('id', $chestId)->update($request->inputData());

        return redirect()->action('Admin\ChestsController@getIndex');
    }

    public function getDelete($chestId)
    {
        Chest::where('id', $chestId)->delete();

        return redirect()->action('Admin\ChestsController@getIndex');
    }
}
