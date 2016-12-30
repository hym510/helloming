<?php
namespace App\Library\Readfile;

use App\Models\XmlUrl;
use App\Models\XmlManagement;

class ReadFileUrl
{
    public static function Fileload($data)
    {
        $url = XmlUrl::where('flag', 1)->first();
        $filename = XmlManagement::where('xmlname', $data)->first();
        $path = rtrim($url->urlname. $filename['xmlname']);
        $xml = file_get_contents($path);
        file_put_contents('public/uploads/'. $filename['xmlname'], $xml);
    }
}
