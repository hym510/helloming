<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    public function getQiniuToken()
    {
        //获取七牛上传token
        return app('response')->success(app('qiniu')->getToken());
    }
}
