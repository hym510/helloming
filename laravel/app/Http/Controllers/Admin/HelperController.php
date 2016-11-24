<?php

namespace App\Http\Controllers\Admin;

use Json;
use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    public function getQiniuToken()
    {
        return Json::success(app('qiniu')->getToken());
    }
}
