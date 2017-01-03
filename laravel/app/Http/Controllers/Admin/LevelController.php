<?php

namespace App\Http\Controllers\Admin;

use App\Models\LevelAttr;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    public function getIndex()
    {
        return view('admin.levels.index',
            ['levels' => LevelAttr::orderBy('level', 'asc')->get()]
        );
    }
}
