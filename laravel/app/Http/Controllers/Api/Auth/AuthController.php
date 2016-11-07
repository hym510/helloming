<?php

namespace App\Http\Controllers\Api\Auth;

use Json;
use Smser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\{PhoneNumber, User};
use App\Http\Requests\Api\{SigninRequest, SignupRequest};

class AuthController extends Controller
{
    public function postSignupSms(Request $request)
    {
        if (PhoneNumber::isExist($request->phone)) {
            return Json::error(
                'Mobile phone number has already been taken.', 214
            );
        }

        if (Smser::requestSmsCode($request->phone)) {
            return Json::success();
        } else {
            return Json::error('Fails to send message.', 602);
        }
    }

    public function postSignin(SigninRequest $request)
    {
        if (! Smser::verifySmsCode($request->phone, $request->code)) {
            return Json::error('Invalid SMS code.', 603);
        }

        if (! PhoneNumber::isExist($request->phone)) {
            return Json::error(
                'A user with the specified mobile phone number was not found.', 213
            );
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
