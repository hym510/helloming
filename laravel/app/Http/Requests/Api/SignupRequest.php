<?php

namespace App\Http\Requests;

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
