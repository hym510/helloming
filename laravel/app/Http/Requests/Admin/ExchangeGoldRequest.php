<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ExchangeGoldRequest extends Request
{
    public function rules()
    {
        return [
            'gold' => 'required|numeric',
            'money' => 'required|numeric',
        ];
    }
}
