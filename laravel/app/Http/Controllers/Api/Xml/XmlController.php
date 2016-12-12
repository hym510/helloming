<?php

namespace App\Http\Controllers\Api\Xml;

use Json;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;

class XmlController extends Controller
{
    public function getDownload($file)
    {
        $file = app()->make('path.public').'/uploads/'.$file.'.xml';

        if (file_exists($file)) {
            return app(ResponseFactory::class)->download($file);
        } else {
            return Json::error("File doesn't exist.", 101);
        }
    }
}
