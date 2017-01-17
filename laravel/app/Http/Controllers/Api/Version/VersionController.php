<?php

namespace App\Http\Controllers\Api\Version;

use Json;
use App\Models\Version;
use Illuminate\Routing\Controller;

class VersionController extends Controller
{
    public function getVersion()
    {
        $version = Version::where('mark', 1)->first();

        return Json::success(['version' => $version->app_version]);
    }
}
