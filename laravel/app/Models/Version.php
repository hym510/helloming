<?php

namespace App\Models;

class Version extends Model
{
    public function getMarkTypeAttribute(): string
    {
        if ($this->mark == 1){
            $mark = '当前版本';
        } else {
            $mark = '历史版本';
        }

        return $mark;
    }
}
