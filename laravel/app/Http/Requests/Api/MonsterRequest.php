<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class MonsterRequest extends Request
{
    public function rules()
    {
        return [
            'host_event_id' => 'required',
            'atk' => 'required',
        ];
    }
}
