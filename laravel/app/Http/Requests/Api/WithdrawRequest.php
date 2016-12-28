<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class WithdrawRequest extends Request
{
    public function rules()
    {
        return [
            'password' => 'required',
        ];
    }
}
