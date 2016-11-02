<?php

namespace App\Models;

class Event extends Model
{
    protected $table = 'events';

    public function getPrizeAttribute($value)
    {
        return json_decode($value);
    }

    public static function random($level): array
    {
        return static::where('unlock_level', '<=', $level)
            ->orderByRaw('RAND()')
            ->limit(6)
            ->get([
                'id', 'type', 'mine_id',
                'monster_id', 'fortune_id', 'info'
            ])
            ->toArray();
    }
}
