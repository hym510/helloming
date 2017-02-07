<?php

use Illuminate\Database\Seeder;

use App\Models\XmlUrl;
use App\Models\Conversion;

class UrlTableSeeder extends Seeder
{
    public function run()
    {
        XmlUrl::truncate();
        Conversion::truncate();

        XmlUrl::insert([
            'urlname' => 'http://octhkzxil.bkt.clouddn.com/',
        ]);

        Conversion::insert([
            'exchange' => '1',
            ]);
    }
}
