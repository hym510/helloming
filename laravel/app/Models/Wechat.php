<?php

namespace App\Models;

class Wechat extends Model
{
    protected $table = 'wechat';

    public static function addOne(string $unionId, string $openId)
    {
        $model = new static;
        $model->union_id = $unionId;
        $model->open_id = $openId;

        $model->save();
    }
}
