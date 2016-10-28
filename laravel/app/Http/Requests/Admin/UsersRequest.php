<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UsersRequest extends Request
{
    public function rules()
    {
        return [
            'name'  => 'required',
            'phone' => 'required|numeric',
            'age'   => 'required|numeric',
            'weight'    => 'required|numeric',
            'height'    => 'required|numeric',
            'online_time'   => 'required|numeric',
        ];
    }
}
