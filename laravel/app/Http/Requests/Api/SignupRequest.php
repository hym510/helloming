<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class SignupRequest extends Request
{
    public function rules()
    {
        return [
            'phone' => 'required',
            'name' => 'required|max:10',
            'gender' => 'required|in:male,female',
            'job_id' => 'required',
        ];
    }
}
