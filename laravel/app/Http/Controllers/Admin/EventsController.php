<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    public function getIndex()
    {
        return view('admin.events.index', ['events' => Event::get()]);
    }
}
