<?php

namespace App\Models;

class Event extends Model
{
    protected $table = 'events';

    public function getPrizeAttribute($value)
    {
        return json_decode($value);
    }

    public function getTypeNameAttribute(): string
    {
        switch ($this->type) {
            case 'monster':
                $type = '打怪事件';
                break;
            case 'mine':
                $type = '挖矿事件';
                break;
            case 'chest':
                $type = '宝箱事件';
                break;
        }

        return $type;
    }

    public static function random($level, $count): array
    {
        return static::where('unlock_level', '<=', $level)
            ->orderByRaw('RAND()')
            ->limit(6 - $count)
            ->get(['id'])
            ->pluck('id')
            ->toArray();
    }
}
