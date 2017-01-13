<?php

namespace App\Http\Controllers\Admin;

use App\Models\Consume;

class ConsumeController extends Controller
{
    public function getIndex()
    {
        $consumes = Consume::with('user')->when(request('keyword'), function ($q) {
            return $q->whereHas('user', function ($k) {
                return $k->where('name', request('keyword'));
            });
        })
        ->paginate()->appends(request()->all());

        return view('admin.consume.index', compact('consumes'));
    }
}
