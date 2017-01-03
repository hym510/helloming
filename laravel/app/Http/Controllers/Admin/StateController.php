<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Models\StateAttr;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    protected function updateCache()
    {
        Redis::set('state_attributes',
            json_encode(StateAttr::orderBy('level', 'asc')->get(['power'])->toArray())
        );
    }

    public function getIndex()
    {
        $stateattrs = StateAttr::paginate()->appends(request()->all());

        return view('admin.state.index', compact('stateattrs'));
    }

}
