<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\XmlUrl;
use App\Models\Conversion;

class UrlTableSeeder extends Seeder
{
    public function run()
    {
        XmlUrl::truncate();
        Conversion::truncate();
        $time = Carbon::now();

        XmlUrl::insert([
            'urlname' => 'http://octhkzxil.bkt.clouddn.com/',
            'created_at' => $time,
            'updated_at' => $time,
        ]);

        Conversion::insert([
            'exchange' => '1',
            ]);
    }
}
