<?php

use Illuminate\Database\Seeder;

use  App\Models\XmlUrl;

class UrlTableSeeder extends Seeder
{
    public function run()
    {
        XmlUrl::truncate();

        XmlUrl::insert([
            'urlname' => 'http://octhkzxil.bkt.clouddn.com/',
        ]);
    }
}
