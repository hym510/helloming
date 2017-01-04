<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class ExpenseController extends Controller
{
    public function getIndex()
    {
        return view('admin.expense.index');
    }

    public function postImportXml(Request $request)
    {
        $xml = $request->xml->storeAs('uploads', 'expense.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $expenses = ReadXml::readDatabase($path);

        foreach ($expenses as $expense){
            $data = [
                'id' => $expense['id_i'],
                'price' => $expense['price_i'],
                'currency' => $expense['currency_i'],
            ];
            $all[] = $data;
        }

        Redis::set('expense', json_encode($all));

        return $this->backSuccessMsg('成功添加xml文件');
    }
}
