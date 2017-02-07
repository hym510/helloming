<?php

namespace App\Http\Controllers\Api\Conversion;

use Json;
use App\Models\Conversion;
use Illuminate\Routing\Controller;

class ConversionController extends Controller
{
    public function getConversion()
    {
        $conversion = Conversion::where('id', 1)->first();

        return Json::success(['exchange' => $conversion->exchange]);
    }
}
