<?php

namespace App\Http\Controllers\Api\Data;

use Json;
use App\Models\Job;
use Illuminate\Routing\Controller;

class JobController extends Controller
{
    public function getAll()
    {
        return Json::success(Job::getAll());
    }
}
