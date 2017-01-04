<?php

namespace App\Http\Controllers\Admin;

use App\Models\Equipment;
use App\Http\Controllers\Admin\Controller;

class EquipmentsController extends Controller
{
    public function getIndex()
    {
        $equips = Equipment::paginate()->appends(request()->all());

        return view('admin.equipments.index', compact('equips'));
    }
}
