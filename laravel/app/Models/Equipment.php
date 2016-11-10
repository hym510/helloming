<?php

namespace App\Models;

class Equipment extends Model
{
    protected $table = 'equipment';

    public function getUpgradeAttribute($value)
    {
        return json_decode($value);
    }
}
