<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public static function isExist(array $columns, $id = null): bool
    {
        return static::when($id, function ($q) use ($id) {
            return $q->where('id', '<>', $id);
        })->where($columns)->take(1)->count() > 0;
    }

    public static function getValue($id, $key)
    {
        $row = static::find($id, [$key]);

        if ($row) {
            return $row->{$key};
        }
    }

    public static function getValues($id, array $keys): array
    {
        return static::where('id', $id)->first($keys)->toArray();
    }

    public static function getKeyValue($key, $value, array $keys): array
    {
        return static::where($key, $value)->first($keys)->toArray();
    }

    public static function updateValue($id, array $columns)
    {
        static::where('id', $id)->update($columns);
    }
}
