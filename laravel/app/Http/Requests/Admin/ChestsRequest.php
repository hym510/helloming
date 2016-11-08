<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ChestsRequest extends Request
{
    public function rules()
    {
        return [
            'cost_type' => 'required',
            'item_id' => 'numeric',
            'cost' => 'numeric',
            'prize' => 'json',
        ];
    }
}
