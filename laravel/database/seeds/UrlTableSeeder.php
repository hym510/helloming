<?php

use Illuminate\Database\Seeder;

use  App\Models\XmlUrl;

class UrlTableSeeder extends Seeder
{
    public function run()
    {
        XmlUrl::truncate();

        XmlUrl::insert([
            'urlname' => '/Users/ganguo/Downloads/配置文件/',
        ]);
    }
}
