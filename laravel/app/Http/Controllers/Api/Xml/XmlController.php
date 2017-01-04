<?php

namespace App\Http\Controllers\Api\Xml;

use Json;
use App\Models\XmlManagement;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;

class XmlController extends Controller
{
    public function getDownload($file)
    {
        $filedata = XmlManagement::where('xmlname', $file . '.xml')->where('mark', 1)->first();
        $filename = explode('.', $filedata['xmlname']);
        $file = app()->make('path.public') . '/uploads/' . $filename[0] . '_' . $filedata['version'] . '.xml';

        if (file_exists($file)) {
            return app(ResponseFactory::class)->download($file);
        } else {
            return Json::error("File doesn't exist.", 101);
        }
    }
}
