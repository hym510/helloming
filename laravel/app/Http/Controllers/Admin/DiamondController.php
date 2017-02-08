<?php

namespace App\Http\Controllers\Admin;

use App\Models\Diamond;
use App\Http\Requests\Admin\DiamondRequest;

class DiamondController extends Controller
{
    public function getIndex()
    {
        $diamonds = Diamond::paginate()->appends(request()->all());

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
        $diamond = Diamond::findOrFail($diamondId);

        return view('admin.diamond.edit', compact('diamond'));
    }

    public function postStore(DiamondRequest $request)
    {
        $data = $request->inputData();
        Diamond::create($data);

        return redirect()->action('Admin\DiamondController@getIndex');
    }

    public function postUpdate(DiamondRequest $request, $diamondId)
    {
        $data = $request->inputData();
        $diamond = Diamond::findOrFail($diamondId);
        $diamond->update($data);

        return redirect()->action('Admin\DiamondController@getIndex');
    }
}
