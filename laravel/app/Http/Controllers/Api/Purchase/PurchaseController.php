<?php

namespace App\Http\Controllers\Api\Purchase;

use Json;
use Exception;
use App\Library\IAP\IAP;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PurchaseController extends Controller
{
    public function postVerify(Request $request)
    {
        try {
            IAP::getReceiptData($request->receipt, true);

            return Json::success();
        } catch (Exception $e) {
            return Json::error('Invalid receipt.', 703);
        }
    }
}
