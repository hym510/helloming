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
            return $q->where('id', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.equipments.index', compact('equipments'));
    }

    public function getAdd()
    {
        return view('admin.equipments.edit');
    }

    public function getEdit($id)
    {
        $equipment = Equipment::findOrFail($id);

        return view('admin.equipments.edit', compact('equipment'));
    }

    public function postStore(EquipmentsRequest $request)
    {
        Equipment::create($request->inputData());

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }

    public function postUpdate(EquipmentsRequest $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->inputData());

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }

    public function getDelete($id)
    {
        Equipment::findOrFail($id)->delete();

        return redirect()->action('Admin\EquipmentsController@getIndex');
    }
}
