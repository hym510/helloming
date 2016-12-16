<?php

namespace App\Http\Controllers\Admin;

use Redis;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $events = ReadXml::readDatabase($path);
        foreach ($events as $event){
            $data = [
                'type' => 'type_i',
                'price' => 'price_i',
                'currency' => 'currency_i',
            ];
            Redis::set('expense', json_encode($data));
        }

        return redirect()->action('Admin\ExpenseController@getIndex');
    }
}
