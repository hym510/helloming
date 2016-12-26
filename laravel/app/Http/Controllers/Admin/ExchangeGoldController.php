<?php

namespace App\Http\Controllers\Admin;

use Redis;
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
        Redis::set('ExchangeGold', json_encode(['gold' => $data['gold'], 'money' => $data['money']]));

        return $this->backSuccessMsg('设置成功');
    }
}
