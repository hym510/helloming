<?php

namespace App\Http\Controllers\Admin;

use App\Models\Monster;

class MonstersController extends Controller
{
    public function getIndex()
    {
        return view('admin.monsters.index', ['monsters' => Monster::paginate()]);
    }
}
