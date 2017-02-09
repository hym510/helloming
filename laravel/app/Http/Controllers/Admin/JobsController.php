<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;

class JobsController extends Controller
{
    public function getIndex()
    {
        return view('admin.job.index', [
            'jobs' => Job::paginate()->appends(request()->all())
        ]);
    }
}
