<?php

namespace App\Models;

class Monster extends Model
{
    protected $table = 'monsters';

    protected $fillable = [
        'id', 'name', 'level', 'hp',
    ];

    public function getTypeNameAttribute()
    {
        if ($this->type == 'boss') {
            $type = 'boss怪';
        } else {
            $type = '普通怪';
        }

        return $type;
    }

    public static function atk($id, $userId, $atk): bool
    {
        $hp = static::getValue($id, 'hp');

        if (! User::consumePower($userId, $atk)) {
            return false;
        }

        if ($atk >= $hp) {
            return true;
        } else {
            return false;
        }
    }
}
