<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class MonstersRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:16',
            'icon' => 'required',
            'type' => 'required',
            'level' => 'numeric',
            'hp' => 'numeric',
            'kill_limit_time' => 'numeric',
        ];
    }
}
