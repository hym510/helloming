<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public static function isExist(array $column): bool
    {
        return static::whereExists(function ($query) use ($column) {
            $query->where($column)->take(1);
        })->count() > 0;
    }

    public static function getValue($id, $key)
    {
        $row = static::find($id, [$key]);

        if ($row) {
            return $row->{$key};
        }
    }

    public static function getKeyValue(array $column, array $key): array
    {
        $model = static::where($column)->first($key);

        if ($model) {
            return $model->toArray();
        } else {
            return [];
        }
    }

    public static function updateValue($id, array $column)
    {
        static::where('id', $id)->update($column);
    }
}
