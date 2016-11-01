<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ItemRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'priority' => 'required|numeric',
            'type' => 'required',
        ];
    }
}
