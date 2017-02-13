<?php

namespace App\Http\Controllers\Admin;

use App\Models\Version;
use App\Http\Requests\Admin\VersionRequest;

class VersionController extends Controller
{
    public function getIndex()
    {
        return view('admin.version.index', [
            'versions' => Version::where('mark', 1)->paginate()->appends(request()->all())
        ]);
    }

    public function getEdit($versionId)
    {
        $version = Version::findOrFail($versionId);

        return view('admin.version.edit', [
            'version' => Version::findOrFail($versionId)
        ]);
    }

    public function postStore(VersionRequest $request, $versionId)
    {
        Version::where('mark', 1)
            ->findOrFail($versionId)
            ->update(['mark' => 0]);

        Version::create($request->inputData());

        return redirect()->action('Admin\VersionController@getIndex');
    }

}
