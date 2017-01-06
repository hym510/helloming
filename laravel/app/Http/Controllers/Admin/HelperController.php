<?php

namespace App\Http\Controllers\Admin;

use Json;

class HelperController extends Controller
{
    public function getQiniuToken()
    {
        //获取七牛上传token
        return Json::success(app('qiniu')->getToken());
    }
}
