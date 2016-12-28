<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class RedpackRequest extends Request
{
    public function rules()
    {
        return [
            'gold' => 'required',
            'withdraw_password' => 'required',
        ];
    }
}
