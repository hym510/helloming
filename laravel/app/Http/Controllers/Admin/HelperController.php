<?php

namespace App\Http\Controllers\Admin;

use Json;

class HelperController extends Controller
{
    public function getQiniuToken()
    {
        return Json::success(app('qiniu')->getToken());
    }
}
