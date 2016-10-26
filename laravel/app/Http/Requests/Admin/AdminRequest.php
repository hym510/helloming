<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password'  => 'required_with:password_confirmation|confirmed|min:6',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
