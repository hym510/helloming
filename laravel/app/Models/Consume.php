<?php

namespace App\Models;

class Consume extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
