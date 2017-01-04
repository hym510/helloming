<?php

namespace App\Http\Controllers\Api\Data;

use Json;
use Illuminate\Routing\Controller;

class QiniuController extends Controller
{
    public function getToken()
    {
        $data = app('qiniu')->getToken();

        return Json::success(['token' => $data['token']]);
    }

    public function getDomain()
    {
        $data = app('qiniu')->getToken();

        return Json::success(['domain' => $data['domain']]);
    }
}
