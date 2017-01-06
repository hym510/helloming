<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class DiamondRequest extends Request
{
    public function rules()
    {
        return [
            'icon' => 'required',
            'diamond' => 'required',
            'price' => 'required|numeric',
            'count' => 'required|numeric',
        ];
    }
}
