<?php

namespace App\Http\Requests;

use Json;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function response(array $errors)
    {
        if ($this->segment(1) == 'api') {
            return Json::error(current(current($errors)));
        }

        return parent::response($errors);
    }
}
