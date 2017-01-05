<?php

namespace App\Http\Controllers\Api\Data;

use Json;
use App\Library\Redis\ConfigRedis;
use Illuminate\Routing\Controller;

class ExchangeController extends Controller
{
    public function getGold()
    {
        return Json::success(['exchange' => json_decode(ConfigRedis::get('gold_exchange'))]);
    }
}
