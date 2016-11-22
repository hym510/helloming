<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Models\LevelAttr;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LevelRequest;

class LevelController extends Controller
{
    protected function updateCache()
    {
        Redis::set('level_attributes',
            json_encode(LevelAttr::orderBy('level', 'asc')->get()->toArray())
        );
    }

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
        $this->updateCache();

        return redirect()->action('Admin\LevelController@getIndex');
    }

    public function postStore(LevelRequest $request)
    {
        LevelAttr::create($request->inputData());
        $this->updateCache();

        return redirect()->action('Admin\LevelController@getIndex');
    }

    public function getDelete($levelId)
    {
        LevelAttr::findOrFail($levelId)->delete();

        return redirect()->action('Admin\LevelController@getIndex');
    }
}
