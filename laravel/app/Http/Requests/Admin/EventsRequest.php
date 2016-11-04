<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class EventsRequest extends Request
{
    public function rules()
    {
        return [
            'type' => 'required',
            'level' => 'required|numeric',
            'mine_id' => 'numeric',
            'monster_id' => 'numeric',
            'chest' => 'required|numeric',
            'exp' => 'required|numeric',
            'unlock_level' => 'required|numeric',
            'weight' => 'required|numeric',
            'info' => 'required|numeric',
        ];
    }
}
