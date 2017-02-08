<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;

class ItemsController extends Controller
{
    public function getIndex()
    {
        return view('admin.items.index', [
            'xmlitems' => Item::paginate()->appends(request()->all())
        ]);
    }
}
