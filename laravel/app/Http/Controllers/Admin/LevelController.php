<?php

namespace App\Http\Controllers\Admin;

use App\Models\LevelAttr;
use App\Http\Controllers\Admin\Controller;

class LevelController extends Controller
{
    public function getIndex()
    {
        return view('admin.levels.index',
            ['levels' => LevelAttr::orderBy('level', 'asc')->get()]
        );
    }
}
