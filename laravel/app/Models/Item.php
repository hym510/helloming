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

    public function getQualityNameAttribute(): string
    {
        switch ($this->quality) {
            case '1':
                $quality= '绿色';
                break;
            case '2':
                $quality = '蓝色';
                break;
            case '3':
                $quality = '紫色';
                break;
            case '4':
                $quality = '橙色';
                break;
            case '5':
                $quality = '红色';
                break;
        }

        return $quality;
    }
}
