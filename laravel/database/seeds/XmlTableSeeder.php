<?php

use Carbon\Carbon;
use App\Models\XmlManagement;
use Illuminate\Database\Seeder;
use App\Library\Readfile\ReadFileUrl;
use App\Models\{XmlUrl, Version};

class XmlTableSeeder extends Seeder
{
    public function run()
    {
        Version::truncate();
        Xmlmanagement::truncate();
        $time = Carbon::now();

        XmlManagement::insert([
            'xmlname' => 'event.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'item.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'equipRating.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'equip.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'expense.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'job.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'userPropery.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'monster.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'shop.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'userState.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'freeShoe.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        XmlManagement::insert([
            'xmlname' => 'general.xml',
            'version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
        ]);
        Version::insert([
            'app_version' => '1.0.0',
            'created_at' => $time,
            'updated_at' => $time,
            ]);

        ReadFileUrl::FileGroupLoad();
    }
}
