<?php

namespace App\Http\Controllers\Admin;

use App\Models\LevelAttr;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LevelRequest;

class LevelController extends Controller
{
    public function getIndex()
    {
        $levels = LevelAttr::orderBy('level', 'asc')->get();

        return view('admin.levels.index', compact('levels'));
    }

    public function getAdd()
    {
        return view('admin.levels.edit');
    }

    public function getEdit($levelId)
    {
        $level = LevelAttr::findOrFail($levelId);

        return view('admin.levels.edit', compact('level'));
    }

    public function postUpdate(LevelRequest $request, $levelId)
    {
        LevelAttr::where('id', $levelId)->update($request->inputData());

        return redirect()->action('Admin\LevelController@getIndex');
    }

    public function postStore(LevelRequest $request)
    {
        LevelAttr::create($request->inputData());

        return redirect()->action('Admin\LevelController@getIndex');
    }

    public function getDelete($levelId)
    {
        LevelAttr::findOrFail($levelId)->delete();

        return redirect()->action('Admin\LevelController@getIndex');
    }
}
