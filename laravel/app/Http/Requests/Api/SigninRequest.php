<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class SigninRequest extends Request
{
    public function rules()
    {
        return [
            'phone' => 'required',
            'code' => 'required',
        ];
    }
}
