<?php
namespace App\Library\Readfile;

use Redis;
use App\Library\Xml\ReadXml;
use App\Models\{Equipment, Event, Item, Job, LevelAttr, Monster, Shop, StateAttr, XmlUrl, Configure, XmlManagement};

class ReadFileUrl
{
    public static function fileLoad($filename)
    {
        $url = XmlUrl::where('flag', 1)->first();
        $filedata = XmlManagement::where('xmlname', $filename)->first();
        $file = explode('.', $filedata['xmlname']);
        $path = rtrim($url->urlname . $file[0] . '_' . $filedata['version'] . '.xml');
        $xml = file_get_contents($path);
        file_put_contents('public/uploads/' . $file[0] . '_' . $filedata['version'] . '.xml', $xml);
    }

    public static function filePath($filename): array
    {
        $filedata = XmlManagement::where('xmlname', $filename)->where('mark', 1)->first();
        $file = explode('.', $filedata['xmlname']);
        $path = rtrim(public_path() . '/uploads/' . $file[0] . '_' . $filedata['version'] . '.xml');
        $readfile = ReadXml::readDatabase($path);

        return $readfile;
    }

    public static function writeItem($filename)
    {
        $items = static::filePath($filename);
        Item::truncate();

        foreach ($items as $item) {
            $data = [
                'id' => $item['id_i'],
            ];

            Item::create($data);
        }
    }

    public static function writeEquipLevel($filename)
    {
        $equiplevels = static::filePath($filename);
        Configure::where('key', 'equip_rate')->delete();

        foreach ($equiplevels as $equiplevel) {
            $data = [
                'level' => $equiplevel['level_i'],
            ];
            $all[] = $data;
        }

        $jsonData = json_encode($all);
        Redis::set('equip_rate', $jsonData);
        Configure::create(['key' => 'equip_rate', 'value' => $jsonData]);
    }

    public static function writeEquipment($filename)
    {
        $equipments = static::filePath($filename);
        Equipment::truncate();

        foreach ($equipments as $equipment) {
            $data = [
                'id' => $equipment['id_i'],
                'name' => $equipment['name_s'],
                'level'  => $equipment['level_i'],
                'max_level' => $equipment['maxLevel_i'],
                'power' => $equipment['power_i'],
                'job_id' => $equipment['career_i'],
                'position' => $equipment['position_i'],
                'upgrade' => $equipment['upgrade_a'],
            ];

            Equipment::create($data);
        }
    }

    public static function writeEvent($filename)
    {
        $events = static::filePath($filename);
        Event::truncate();

        foreach ($events as $event) {
            $prize = '[' . $event['rewardItem_a'] . ']';
            $data = [
                'id' => $event['id_i'],
                'type' => $event['type_i'],
                'level' => $event['level_i'],
                'type_id' => $event['obj_i'],
                'exp' => $event['rewardExp_i'],
                'unlock_level' => $event['startLevel_i'],
                'weight' => $event['weight_i'],
                'prize' => $prize,
                'info' => $event['info_s'],
                'time_limit' => $event['timeLimit_i'],
                'finish_item_id' => $event['finishItem_i'],
                'item_quantity' => $event['finishItemQuantity_i'],
            ];

            if ($event['timeLimit_i'] == 1) {
                $array = array_collapse([$data, ['time' => $event['time_i']]]);
                Event::create($array);
            } else {
                Event::create($data);
            }
        }
    }

    public static function writeExpense($filename)
    {
        $expenses = static::filePath($filename);
        Configure::where('key', 'expense')->delete();

        foreach ($expenses as $expense){
            $data = [
                'id' => $expense['id_i'],
                'price' => $expense['price_i'],
                'currency' => $expense['currency_i'],
            ];
            $all[] = $data;
        }

        $jsonData = json_encode($all);
        Redis::set('expense', $jsonData);
        Configure::create(['key' => 'expense', 'value' => $jsonData]);
    }

    public static function writeJob($filename)
    {
        $jobs = static::filePath($filename);
        Job::truncate();

        foreach ($jobs as $job) {
            $data = [
                'id' => $job['id_i'],
                'name' => $job['name_s'],
            ];

            Job::create($data);
        }
    }

    public static function writeLevel($filename)
    {
        $levels = static::filePath($filename);
        levelAttr::truncate();

        foreach ($levels as $level) {
            $data = [
                'level' => $level['level_i'],
                'exp' => $level['exp_i'],
                'power' => $level['power_i'],
                'action' => $level['action_i'],
            ];

            LevelAttr::create($data);
        }
    }

    public static function writeMonster($filename)
    {
        $monsters = static::filePath($filename);
        Monster::truncate();

        foreach ($monsters as $monster) {
            $data = [
                'id' => $monster['id_i'],
                'name' => $monster['name_s'],
                'level' => $monster['level_i'],
                'hp' => $monster['hp_i'],
            ];

            Monster::create($data);
        }
    }

    public static function writeShop($filename)
    {
        $shops = static::filePath($filename);
        Shop::truncate();

        foreach ($shops as $shop) {
            $data = [
                'item_id' => $shop['item_i'],
                'type'  => $shop['type_i'],
                'price' => $shop['price_i'],
                'quantity' => $shop['quantity_i'],
            ];

            Shop::create($data);
        }
    }

    public static function writeState($filename)
    {
        $states = static::filePath($filename);
        StateAttr::truncate();

        foreach ($states as $state) {
            $data = [
                'level' => $state['id_i'],
                'power' => $state['powerLimit_i'],
            ];

            StateAttr::create($data);
        }
    }

    public static function writeFreeShoe($filename)
    {
        $freeshoes = static::filePath($filename);
        Configure::where('key', 'free_shoe')->delete();

        foreach ($freeshoes as $freeshoe) {
            $data = [
                'time' => $freeshoe['time_a'],
                'quantity' => $freeshoe['quantity_i'],
            ];
            $all[] = $data;
        }

        $jsonData = json_encode($all);
        Redis::set('free_shoe', $jsonData);
        Configure::create(['key' => 'free_shoe', 'value' => $jsonData]);
    }

    public static function writeLifeCycle($filename)
    {
        $eventtimes = static::filePath($filename);
        Configure::whereIn('key', ['life_cycle', 'power_time'])->delete();

        foreach ($eventtimes as $eventtime) {
            $data = [
                'id' => $eventtime['id_i'],
                'value' => $eventtime['value_i'],
            ];

            if ($data['id'] == 1) {
                $datavalue = array_values(($data));
                $jsonData = json_encode($datavalue);
                Redis::set('life_cycle', $jsonData);
                Configure::create(['key' => 'life_cycle', 'value' => $jsonData]);
            } elseif ($data['id'] > 3) {
                $datavalue = array_values(($data));
                $jsonData = json_encode($datavalue);
                Redis::set('power_time', $jsonData);
                Configure::create(['key' => 'power_time', 'value' => $jsonData]);
            }
        }
    }

    public static function FileGroupLoad()
    {
        static::fileLoad('event.xml');
        static::fileLoad('item.xml');
        static::fileLoad('equipRating.xml');
        static::fileLoad('expense.xml');
        static::fileLoad('equip.xml');
        static::fileLoad('job.xml');
        static::fileLoad('userPropery.xml');
        static::fileLoad('monster.xml');
        static::fileLoad('shop.xml');
        static::fileLoad('userState.xml');
        static::fileLoad('freeShoe.xml');
        static::fileLoad('general.xml');

        static::writeEvent('event.xml');
        static::writeItem('item.xml');
        static::writeEquipLevel('equipRating.xml');
        static::writeExpense('expense.xml');
        static::writeEquipment('equip.xml');
        static::WriteJob('job.xml');
        static::writeLevel('userPropery.xml');
        static::writeMonster('monster.xml');
        static::writeShop('shop.xml');
        static::writeState('userState.xml');
        static::writeFreeShoe('freeShoe.xml');
        static::writeLifeCycle('general.xml');
    }
}
