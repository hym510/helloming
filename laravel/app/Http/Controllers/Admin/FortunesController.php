<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fortune;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FortunesRequest;

class FortunesController extends Controller
{
    public function getIndex()
    {
        $fortunes = Fortune::when(request('keyword'), function ($q) {
            return $q->where('id', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.fortunes.index', compact('fortunes'));
    }

    public function getAdd()
    {
        return view('admin.fortunes.edit');
    }

    public function getEdit($id)
    {
        $fortune = Fortune::findOrFail($id);

        return view('admin.fortunes.edit', compact('fortune'));
    }

    public function postStore(FortunesRequest $request)
    {
        $fortunes = $request->inputData();
        Fortune::create($fortunes);

        return redirect()->action('Admin\FortunesController@getIndex');
    }

    public function postUpdate(FortunesRequest $request, $id)
    {
        $data = $request->inputData();
        $fortune = Fortune::findOrFail($id);
        $fortune->update($data);

        return redirect()->action('Admin\FortunesController@getIndex');
    }

    public function getDelete($id)
    {
        Fortune::findOrFail($id)->delete();

        return redirect()->action('Admin\FortunesController@getIndex');
    }
}
