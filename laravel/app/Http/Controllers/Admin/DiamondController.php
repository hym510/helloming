<?php

namespace App\Http\Controllers\Admin;

use App\Models\Diamond;
use App\Http\Requests\Admin\DiamondRequest;

class DiamondController extends Controller
{
    public function getIndex()
    {
        return view('admin.diamond.index', [
            'diamonds' => Diamond::paginate()->appends(request()->all())
        ]);
    }

    public function getAdd()
    {
        return view('admin.diamond.edit');
    }

    public function getEdit($diamondId)
    {
        return view('admin.diamond.edit', [
            'diamond' => Diamond::findOrFail($diamondId)
        ]);
    }

    public function postStore(DiamondRequest $request)
    {
        Diamond::create($request->inputData());

        return redirect()->action('Admin\DiamondController@getIndex');
    }

    public function postUpdate(DiamondRequest $request, $diamondId)
    {
        $diamond = Diamond::findOrFail($diamondId);
        $diamond->update($request->inputData());

        return redirect()->action('Admin\DiamondController@getIndex');
    }
}
