<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    public function getQiniuToken()
    {
        return app('response')->success(app('qiniu')->getToken());
    }
}
