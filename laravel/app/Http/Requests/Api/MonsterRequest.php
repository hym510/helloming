<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class MonsterRequest extends Request
{
    public function rules()
    {
        return [
            'event_id' => 'required',
            'atk' => 'required|digits:1',
        ];
    }
}
