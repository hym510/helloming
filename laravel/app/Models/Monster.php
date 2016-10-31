<?php

namespace App\Models;

class Monster extends Model
{
    protected $table = 'monsters';

    public static function atk($id, $atk): bool
    {
        $hp = static::getValue($id, 'hp');

        if ($atk >= $hp) {
            return true;
        } else {
            return false;
        }
    }
}
