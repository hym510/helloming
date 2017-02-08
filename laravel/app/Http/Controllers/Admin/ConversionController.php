<?php

namespace App\Http\Controllers\Admin;

use App\Models\Conversion;
use App\Http\Requests\Admin\ConversionRequest;

class ConversionController extends Controller
{
    public function getIndex()
    {
        $conversion = Conversion::where('id', '1')->first();

        return view('admin.conversion.index', compact('conversion'));
    }

    public function postUpdate(ConversionRequest $request, $conversionId)
    {
        $conversion = Conversion::findOrfail($conversionId);

        switch ($request->exchange) {
            case '1':
                $conversion->update(['exchange' => 1]);

                return $this->backSuccessMsg('隐藏成功');
            case '0':
                $conversion->update(['exchange' => 0]);

                return $this->backSuccessMsg('取消隐藏');
        }
    }
}
