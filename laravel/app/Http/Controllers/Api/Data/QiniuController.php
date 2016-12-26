<?php

namespace App\Http\Controllers\Api\Data;

use Json;
use Illuminate\Routing\Controller;

class QiniuController extends Controller
{
    public function getToken()
    {
        return Json::success(app('qiniu')->getToken()['token']);
    }
}
