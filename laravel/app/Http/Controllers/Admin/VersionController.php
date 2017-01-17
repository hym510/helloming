<?php

namespace App\Http\Controllers\Admin;

use App\Models\Version;
use App\Http\Requests\Admin\VersionRequest;

class VersionController extends Controller
{
    public function getIndex()
    {
        $versions = Version::where('mark', 1)->paginate()->appends(request()->all());

        return view('admin.version.index', compact('versions'));
    }

    public function getEdit($versionId)
    {
        $version = Version::findOrFail($versionId);

        return view('admin.version.edit', compact('version'));
    }

    public function postStore(VersionRequest $request, $versionId)
    {
        $data = $request->inputData();
        $version = Version::where('mark', 1)->findOrFail($versionId);
        $version->update(['mark' => 0]);
        Version::create($data);

        return redirect()->action('Admin\VersionController@getIndex');
    }

}
