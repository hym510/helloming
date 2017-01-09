<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;

class OrdersController extends Controller
{
    public function getIndex()
    {
        $orders = Order::with('user', 'product')->when(request('keyword'), function($q) {
            return $q->whereHas('user', function($k) {
                return $k->where('name', request('keyword'));
            });
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.order.index', compact('orders'));
    }
}
