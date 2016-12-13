<?php

namespace App\Models;

class Equipment extends Model
{
    protected $fillable = [
        'id', 'name', 'level', 'max_level',
        'power', 'job_id', 'position', 'upgrade',
    ];

    protected $table = 'equipment';

    public function getUpgradeAttribute($value)
    {
        return json_decode($value);
    }
}
