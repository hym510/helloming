<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Models\Configure;
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
        $key = 'gold_exchange';
        $value = json_encode(['gold' => $data['gold'], 'money' => $data['money']]);
        Redis::set($key, $value);
        $cfg = Configure::where('key', $key)->first();
        if ($cfg) {
            $cfg->update(['value' => $value]);
        } else {
            Configure::insert([
                'key' => $key,
                'value' => $value,
            ]);
        }

        return $this->backSuccessMsg('设置成功');
    }
}
