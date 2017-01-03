<?php

namespace App\Http\Controllers\Api\Purchase;

use Auth;
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
            $data = IAP::getReceiptData($request->receipt, true);
        } catch (Exception $e) {
            return Json::error('Invalid receipt.', 703);
        }

        IAP::success(Auth::user()->user, $data['productId']);

        return Json::success();
    }
}
