<?php

namespace App\Http\Controllers\Api\Data;

use App\Models\Job;
use Illuminate\Routing\Controller;

class JobController extends Controller
{
    public function getIndex()
    {
        return Json::success(Job::getAll());
    }
}
