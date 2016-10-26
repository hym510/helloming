<?php

namespace App\Http\Controllers\Api\Auth;

use Json;
use Smser;
use App\Models\User;
use App\Models\PhoneNumber;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SigninRequest;
use App\Http\Requests\Api\SignupRequest;

class AuthController extends Controller
{
    public function postSignin(SigninRequest $request)
    {
        if (! PhoneNumber::isExist($request->phone)) {
            return Json::error(
                'A user with the specified mobile phone number was not found.', 213
            );
        }

        if (! Smser::verifySmsCode($request->phone, $request->code)) {
            return Json::error('Invalid SMS code.', 603);
        }

        return Json::success(User::updateToken($request->phone));
    }

    public function postSignup(SignupRequest $request)
    {
        if (PhoneNumber::isExist($request->phone)) {
            return Json::error(
                'Mobile phone number has already been taken.', 214
            );
        }

        return Json::success(User::signup($request->input()));
    }
}
