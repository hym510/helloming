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
        ReadFileUrl::Fileload('event.xml');
        ReadFileUrl::Fileload('item.xml');
        ReadFileUrl::Fileload('equipRating.xml');
        ReadFileUrl::Fileload('expense.xml');
        ReadFileUrl::Fileload('equip.xml');
        ReadFileUrl::Fileload('job.xml');
        ReadFileUrl::Fileload('userPropery.xml');
        ReadFileUrl::Fileload('monster.xml');
        ReadFileUrl::Fileload('shop.xml');
        ReadFileUrl::Fileload('userState.xml');

        ReadFileUrl::WriteEvent('event.xml');
        ReadFileUrl::WriteItem('item.xml');
        ReadFileUrl::WriteEquipLevel('equipRating.xml');
        ReadFileUrl::WriteExpense('expense.xml');
        ReadFileUrl::WriteEquipment('equip.xml');
        ReadFileUrl::WriteJob('job.xml');
        ReadFileUrl::WriteLevel('userPropery.xml');
        ReadFileUrl::WriteMonster('monster.xml');
        ReadFileUrl::WriteShop('shop.xml');
        ReadFileUrl::WriteState('userState.xml');
    }
}
