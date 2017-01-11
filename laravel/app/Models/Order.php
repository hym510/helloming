<?php

namespace App\Models;

class Order extends Model
{
    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Diamond::class, 'product_id', 'product_id');
    }
}
