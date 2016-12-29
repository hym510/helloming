<?php

namespace App\Http\Controllers\Api\Data;

use Json;
use Redis;
use Illuminate\Routing\Controller;

class ExchangeController extends Controller
{
    public function getGold()
    {
        return Json::success(['exchange' => json_decode(Redis::get('gold_exchange'))]);
    }
}
