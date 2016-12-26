<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExchangeGold;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExchangeGoldRequest;

class ExchangeGoldController extends Controller
{
    public function getIndex()
    {
        return view('admin.exchange.index');
    }

    public function postStore(ExchangeGoldRequest $request)
    {
        $data = $request->inputData();
        ExchangeGold::create($data);

        return $this->backSuccessMsg('设置成功');
    }
}
