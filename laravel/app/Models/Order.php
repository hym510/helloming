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
        return $this->belongsTo(Diamond::class, 'product_id', 'diamond');
    }

    public static function createOrder(array $data): array
    {
        return static::create([
            'user_id' => $data['user_id'],
            'quantity' => $data['quantity'],
            'product_id' => $data['product_id'],
            'transaction_id' => $data['transaction_id'],
            ]);
    }
}
