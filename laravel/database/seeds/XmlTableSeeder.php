<?php

use App\Models\XmlManagement;
use Illuminate\Database\Seeder;
use App\Library\Readfile\ReadFileUrl;
use App\Models\XmlUrl;

class XmlTableSeeder extends Seeder
{
    public function run()
    {
        Xmlmanagement::truncate();

        XmlManagement::insert([
            'xmlname' => 'event.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'item.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'equipRating.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'equip.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'expense.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'job.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'userPropery.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'monster.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'shop.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'userState.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'freeShoe.xml',
            'version' => '1.0.0',
        ]);
        XmlManagement::insert([
            'xmlname' => 'general.xml',
            'version' => '1.0.0',
        ]);

        ReadFileUrl::FileGroupLoad();
    }
}
