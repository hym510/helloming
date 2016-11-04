<?php

namespace App\Models;

class Chest extends Model
{
    protected $table = 'chests';

    public function getPrizeAttribute($value)
    {
        return json_decode($value);
    }

    public function getTypeNameAttribute()
    {
        switch ($this->cost_type) {
            case 'none':
                $type = '不消耗';
                break;
            case 'gold':
                $type = '消耗金币';
                break;
            case 'diamond':
                $type = '消耗钻石';
                break;
        }
        return $type;
    }
}
