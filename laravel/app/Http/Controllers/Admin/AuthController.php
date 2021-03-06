<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Http\Controllers\Admin\Controller;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $data = $request->inputData();

        if (isset($data['remember'])) {
            $remember = true;
            unset($data['remember']);
        } else {
            $remember = false;
        }

        if (auth()->guard('admin')->attempt($data, $remember)) {
            return redirect()->action('Admin\HomeController@getIndex');
        } else {
            return back()->withErrors('账号或者密码错误');
        }
    }

    public function getLogout()
    {
        auth()->logout();

        return redirect()->action('Admin\AuthController@getLogin');
    }
}
