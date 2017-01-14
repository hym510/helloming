<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use Json;
use App\Http\Requests\Admin\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function getReset()
    {
        return view('admin.reset.index', ['user' => Auth::user()]);
    }

    public function putReset(ResetPasswordRequest $request)
    {
        if ($request->password) {
            Auth::user()->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->action('Admin\AuthController@getLogin');
    }
}
