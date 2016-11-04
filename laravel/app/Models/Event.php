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
                'id', 'type', 'level', 'mine_id',
                'monster_id', 'fortune_id', 'info'
            ])
            ->toArray();
    }

    public function getTypeNameAttribute()
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

    public function monster()
    {
        return $this->belongsTo(Monster::class);
    }

    public function mine()
    {
        return $this->belongsTo(Mine::class);
    }

    public function fortune()
    {
        return $this->belongsTo(Fortune::class);
    }
}
