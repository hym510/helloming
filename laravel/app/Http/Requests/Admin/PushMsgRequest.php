<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class PushMsgRequest extends Request
{
    public function rules()
    {
        return [
            'message' => 'required',
        ];
    }
}
