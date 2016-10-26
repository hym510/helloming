<?php

namespace App\Http\Requests;

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
