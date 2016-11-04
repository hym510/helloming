<?php

namespace App\Models;

class Chest extends Model
{
    protected $table = 'chests';

    public function getPrizeAttribute($value)
    {
        return json_decode($value);
    }
}
