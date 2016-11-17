<?php

namespace App\Models;

class Item extends Model
{
    protected $table = 'items';

    public function getTypeNameAttribute(): string
    {
        switch ($this->type) {
            case 'currency':
                $type = '金币';
                break;
            case 'tool':
                $type = '工具';
                break;
            case 'building':
                $type = '建造';
                break;
            case 'nei_dan':
                $type = '内丹';
                break;
        }

        return $type;
    }
}
