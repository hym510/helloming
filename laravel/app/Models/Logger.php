<?php

namespace App\Models;

class Logger extends Model
{
    protected $table = 'log';

    public static function addOne(string $userId, $string $type)
    {
        $model = new static;
        $model->user_id = $userId;
        $model->type = $type;
        $model->time = date('Y-m-d H:i:s');

        $model->save();
    }
}
