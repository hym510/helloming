<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobsController extends Controller
{
    public function getIndex()
    {
        return view('admin.job.index',
            ['jobs' => Job::paginate()->appends(request()->all())]
        );
    }

    public function postImportXml(Request $request)
    {
        Job::truncate();
        $xml = $request->xml->storeAs('uploads', 'jobs.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $jobs = ReadXml::readDatabase($path);

        foreach ($jobs as $job) {
            $data = [
                'id' => $job['id_i'],
                'name' => $job['name_s'],
            ];

            Job::create($data);
        }

        return redirect()->action('Admin\JobsController@getIndex');
    }
}
