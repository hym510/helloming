<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class EquipmentsRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'level' => 'required|numeric',
            'max_level' => 'numeric',
            'power' => 'required|numeric',
            'job_id' => 'required|numeric',
            'position' => 'required',
            'upgrade' => 'required',
            'icon' => 'required',
        ];
    }
}
