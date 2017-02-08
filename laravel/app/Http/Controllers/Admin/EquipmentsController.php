<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;

class EquipmentsController extends Controller
{
    public function getIndex()
    {
        return view('admin.equipments.index', [
            'equips' => Equipment::paginate()->appends(request()->all())
        ]);
    }
}
