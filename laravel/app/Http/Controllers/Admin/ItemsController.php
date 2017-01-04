<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Http\Controllers\Admin\Controller;

class ItemsController extends Controller
{
    public function getIndex()
    {
        $xmlitems = Item::paginate()->appends(request()->all());

        return view('admin.items.index', compact('xmlitems'));
    }
}
