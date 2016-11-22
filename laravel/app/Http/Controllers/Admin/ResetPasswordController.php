<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function getReset()
    {
        $user = Auth::user();

        return view('admin.reset.index', compact('user'));
    }

    public function putReset(ResetPasswordRequest $request)
    {
        Auth::user()->update(['password' => Hash::make($request->password)]);

        return Json::success();
    }
}
