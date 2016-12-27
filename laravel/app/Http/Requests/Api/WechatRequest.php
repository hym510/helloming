<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class WechatRequest extends Request
{
    public function rules()
    {
        return [
            'unionid' => 'required',
        ];
    }
}
