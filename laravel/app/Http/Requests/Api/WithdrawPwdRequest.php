<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class WithdrawPwdRequest extends Request
{
    public function rules()
    {
        return [
            'code' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ];
    }
}
