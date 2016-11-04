<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class MinesRequest extends Request
{
    public function rules()
    {
        return [
            'icon'  => 'required',
            'name'  => 'required|min:2|max:16',
            'time'  => 'numeric',
            'consume_diamond' => 'numeric',
        ];
    }
}
