<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required|min:3|max:32',
        ];
    }

    public function attributes()
    {
        return [
            'email' => '帐号',
            'password' => '密码'
        ];
    }
}
