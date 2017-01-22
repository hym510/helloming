<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class VersionRequest extends Request
{
    public function rules()
    {
        return [
            'app_version' => 'required',
        ];
    }
}
