<?php

namespace App\Library\Excel;

use Config;
use Excel;
class ReadExcel
{
    public static function getExcel($file)
    {
        Config::set('excel.import.to_ascii', false);
        return Excel::load($file, function($reader) {}, 'UTF-8')->get();
    }

}

