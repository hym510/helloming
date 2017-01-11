<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class DiamondRequest extends Request
{
    public function rules()
    {
        return [
            'icon' => 'required',
            'product_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
    }
}
