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
        $xml = $request->xml->store('uploads');
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $jobs = ReadXml::readDatabase($path);
        foreach ($jobs as $job){
            $data = [
                'id' => $job['id_i'],
                'name' => $job['name_s'],
            ];
            Job::create($data);
        }

        return redirect()->action('Admin\JobsController@getIndex');
    }
}
