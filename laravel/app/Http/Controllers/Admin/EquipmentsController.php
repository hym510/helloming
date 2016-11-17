<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EquipmentsRequest;

class EquipmentsController extends Controller
{
    public function getIndex()
    {
        $equipments = Equipment::when(request('keyword'), function ($q) {
            return $q->where('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.equipments.index', compact('equipments'));
    }

    public function getAdd()
    {
        return view('admin.equipments.edit');
    }

    public function getEdit($equipId)
    {
        $equipment = Equipment::findOrFail($equipId);

        return view('admin.equipments.edit', compact('equipment'));
    }

    public function postStore(EquipmentsRequest $request)
    {
        Equipment::create($request->inputData());

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }

    public function postUpdate(EquipmentsRequest $request, $equipId)
    {
        Equipment::where('id', $equipId)->update($request->inputData());

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }

    public function getDelete($equipId)
    {
        Equipment::where('id', $equipId)->delete();

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }
}
