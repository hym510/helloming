<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required_with:password_confirmation|confirmed|min:6',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
