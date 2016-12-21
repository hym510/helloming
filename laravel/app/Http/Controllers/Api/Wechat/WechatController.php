<?php

namespace App\Http\Controllers\Api\Wechat;

use App\Library\Withdraw\Wechat;
use Illuminate\Routing\Controller;

class WechatController extends Controller
{
    public function postSubscribe()
    {
        return Wechat::subscribe();
    }
}
