<?php

namespace App\Models;

class Wechat extends Model
{
    protected $table = 'wechat';

    public static function addOne(string $openId, string $unionId)
    {
        $model = new static;
        $model->open_id = $openId;
        $model->union_id = $unionId;

        $model->save();
    }
}
