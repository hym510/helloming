<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Library\Xml\ReadXml;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    public function getIndex()
    {
        return view('admin.events.index', ['events' => Event::get()]);
    }

    public function postImportXml(Request $request)
    {
        Event::truncate();
        $xml = $request->xml->storeAs('uploads', 'event.xml', 'xml');
        $path = rtrim(public_path(). '/' . ltrim($xml, '/'));
        $events = ReadXml::readDatabase($path);

        foreach ($events as $event) {
            $prize = '['. $event['rewardItem_a'] .']';
            $data = [
                'id' => $event['id_i'],
                'type' => $type,
                'level' => $event['level_i'],
                'type_id' => $event['obj_i'],
                'exp' => $event['rewardExp_i'],
                'unlock_level' => $event['startLevel_i'],
                'weight' => $event['weight_i'],
                'prize' => $prize,
                'info' => $event['info_s'],
                'time_limit' => $event['timeLimit_i'],
            ];

            if ($event['timeLimit_i'] == 1) {
                $array = array_collapse([$data, ['time' => $event['time_i']]]);
                Event::create($array);
            } else {
                Event::create($data);
            }
        }

        return redirect()->action('Admin\EventsController@getIndex');
    }
}
