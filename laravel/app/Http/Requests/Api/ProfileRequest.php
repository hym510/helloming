<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class ProfileRequest extends Request
{
    public function rules()
    {
        return [
            'height' => 'between:1,3',
            'weight' => 'between:1,3',
            'age' => 'between:1,3',
            'zodiac' => 'in:aquarius, pisces, aries,
                        taurus, gemini, cancer, leo, virgo,
                        libra, scorpio, sagittarius, capricorn',
        ];
    }
}
