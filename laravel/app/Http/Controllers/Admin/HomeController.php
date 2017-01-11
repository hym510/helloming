<?php

namespace App\Http\Controllers\Admin;

class HomeController extends Controller
{
    public function getIndex()
    {
        return view('admin.widget.body');
    }
}
