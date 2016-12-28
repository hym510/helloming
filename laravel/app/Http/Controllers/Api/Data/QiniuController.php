<?php

namespace App\Http\Controllers\Api\Data;

use Json;
use Illuminate\Routing\Controller;

class QiniuController extends Controller
{
    public function getToken()
    {
        return Json::success(['token' => app('qiniu')->getToken()['token']]);
    }
}
