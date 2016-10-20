<?php

namespace App\Http\Controllers\Api\Auth;

use Json;
use Smser;
use App\Models\User;
use App\Http\Requests\SigninRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function postSignin(SigninRequest $request)
    {
        if (! User::isExist(['phone' => $request->phone])) {
            return Json::error(
                'A user with the specified mobile phone number was not found.', 213
            );
        }

        if (! Smser::verifySmsCode($request->phone, $request->code)) {
            return Json::error('Invalid SMS code.', 603);
        }

        return Json::success(User::updateToken($request->phone));
    }
}
