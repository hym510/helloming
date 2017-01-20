<?php

namespace App\Models;

class Configure extends Model
{
    protected $fillable = ['id', 'key', 'value'];

    protected $table = 'configure';
}
