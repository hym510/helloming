<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function getReset()
    {
        $user = auth()->user();

        return view('admin.reset.index', compact('user'));
    }

    public function putReset(ResetPasswordRequest $request)
    {
        auth()->user()->update(['password' => bcrypt($request->password)]);

        return $this->success('更改成功');
    }
}