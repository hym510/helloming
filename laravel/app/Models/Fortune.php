<?php

namespace App\Models;

class Fortune extends Model
{
    protected $table = 'fortunes';

    public function getPrizeAttribute($value)
    {
        return json_decode($value);
    }
}
