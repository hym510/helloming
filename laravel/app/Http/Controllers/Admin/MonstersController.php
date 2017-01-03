<?php

namespace App\Http\Controllers\Admin;

use App\Models\Monster;
use App\Http\Controllers\Controller;

class MonstersController extends Controller
{
    public function getIndex()
    {
        return view('admin.monsters.index', ['monsters' => Monster::paginate()]);
    }
}
