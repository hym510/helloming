<?php

namespace App\Models;

class Monster extends Model
{
    protected $table = 'monsters';

    protected $fillable = [
        'id', 'name', 'level', 'hp',
    ];

    public static function atk($id, $userId, $atk): bool
    {
        $hp = static::getValue($id, 'hp');
        User::consumePower($userId, $atk);

        if ($atk >= $hp) {
            return true;
        } else {
            return false;
        }
    }

    public function getTypeNameAttribute()
    {
        if ($this->type == 'boss') {
            $type = 'boss怪';
        } else {
            $type = '普通怪';
        }

        return $type;
    }
}
