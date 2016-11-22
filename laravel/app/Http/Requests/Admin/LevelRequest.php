<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class LevelRequest extends Request
{
    public function rules()
    {
        return [
            'level' => 'required',
            'exp' => 'required|numeric',
            'power' => 'required|numeric',
            'action' => 'required|numeric',
        ];
    }
}
