<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ShopRequest extends Request
{
    public function rules()
    {
        return [
            'item_id' => 'required|numeric',
            'type' => 'required',
            'priority' => 'required|numeric',
            'price' => 'required|numeric',
        ];
    }
}
