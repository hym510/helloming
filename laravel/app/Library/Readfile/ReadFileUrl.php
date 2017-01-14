<?php
namespace App\Library\Readfile;

use Redis;
use App\Library\Xml\ReadXml;
use App\Models\{Equipment, Event, Item, Job, LevelAttr, Monster, Shop, StateAttr, XmlUrl, Configure, XmlManagement};

class ReadFileUrl
{
    public static function Fileload($filename)
    {
        $url = XmlUrl::where('flag', 1)->first();
        $filedata = XmlManagement::where('xmlname', $filename)->first();
        $file = explode('.', $filedata['xmlname']);
        $path = rtrim($url->urlname . $file[0] . '_' . $filedata['version'] . '.xml');
        $xml = file_get_contents($path);
        file_put_contents('public/uploads/' . $file[0] . '_' . $filedata['version'] . '.xml', $xml);
    }

    public static function FilePath($filename): array
    {
        $filedata = XmlManagement::where('xmlname', $filename)->where('mark', 1)->first();
        $file = explode('.', $filedata['xmlname']);
        $path = rtrim(public_path() . '/uploads/' . $file[0] . '_' . $filedata['version'] . '.xml');
        $readfile = ReadXml::readDatabase($path);

        return $readfile;
    }

    public static function WriteItem($filename)
    {
        $items = static::FilePath($filename);
        Item::truncate();
        foreach ($items as $item) {
            $data = [
                'id' => $item['id_i'],
            ];

            Item::create($data);
        }
    }

    public static function WriteEquipLevel($filename)
    {
        $equiplevels = static::FilePath($filename);
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

    public static function WriteEquipment($filename)
    {
        $equipments = static::FilePath($filename);
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

    public static function WriteEvent($filename)
    {
        $events = static::FilePath($filename);
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

    public static function WriteExpense($filename)
    {
        $expenses = static::FilePath($filename);
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

    public static function WriteJob($filename)
    {
        $jobs = static::FilePath($filename);
        Job::truncate();
        foreach ($jobs as $job) {
            $data = [
                'id' => $job['id_i'],
                'name' => $job['name_s'],
            ];

            Job::create($data);
        }
    }

    public static function WriteLevel($filename)
    {
        $levels = static::FilePath($filename);
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

    public static function WriteMonster($filename)
    {
        $monsters = static::FilePath($filename);
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

    public static function WriteShop($filename)
    {
        $shops = static::FilePath($filename);
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

    public static function WriteState($filename)
    {
        $states = static::FilePath($filename);
        StateAttr::truncate();
        foreach ($states as $state) {
            $data = [
                'level' => $state['id_i'],
                'power' => $state['powerLimit_i'],
            ];

            StateAttr::create($data);
        }
    }

    public static function WriteFreeShoe($filename)
    {
        $freeshoes = static::FilePath($filename);
        Configure::where('key', 'freeshoe')->delete();
        foreach ($freeshoes as $freeshoe) {
            $data = [
                'time' => $freeshoe['time_a'],
                'quantity' => $freeshoe['quantity_i'],
            ];
            $all[] = $data;
        }
        $jsonData = json_encode($all);
        Redis::set('free_shoe', $jsonData);
        Configure::create(['key' => 'freeshoe', 'value' => $jsonData]);
    }

    public static function WriteEventTime($filename)
    {
        $eventtimes = static::FilePath($filename);
        Configure::where('key', 'eventtime')->delete();
        foreach ($eventtimes as $eventtime) {
            $data = [
                'id' => 'id_i',
                'value' => 'value_i',
            ];
            $all[] = $data;
        }
        $jsonData = json_encode($all);
        Redis::set('eventtime', $jsonData);
        Configure::create(['key' => 'eventtime', 'value' => $jsonData]);
    }

    public static function FileGroupLoad()
    {
        static::Fileload('event.xml');
        static::Fileload('item.xml');
        static::Fileload('equipRating.xml');
        static::Fileload('expense.xml');
        static::Fileload('equip.xml');
        static::Fileload('job.xml');
        static::Fileload('userPropery.xml');
        static::Fileload('monster.xml');
        static::Fileload('shop.xml');
        static::Fileload('userState.xml');
        static::Fileload('freeShoe.xml');
        static::Fileload('general.xml');

        static::WriteEvent('event.xml');
        static::WriteItem('item.xml');
        static::WriteEquipLevel('equipRating.xml');
        static::WriteExpense('expense.xml');
        static::WriteEquipment('equip.xml');
        static::WriteJob('job.xml');
        static::WriteLevel('userPropery.xml');
        static::WriteMonster('monster.xml');
        static::WriteShop('shop.xml');
        static::WriteState('userState.xml');
        static::WriteFreeShoe('freeShoe.xml');
        static::WriteEventTime('general.xml');
    }
}
