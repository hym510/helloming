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
        $xml = $request->xml->store('uploads');
        $path = rtrim(public_path().config('find.uploads.webpath', '/') . '/' . ltrim($xml, '/'));
        $events = ReadXml::readDatabase($path);
        foreach ($events as $event){
            $data = [
                'type' => $event['type_i'],
                'level' => $event['level_i'],
                'type_id' => $event['obj_i'],
                'exp' => $event['rewardExp_i'],
                'unlock_level' => $event['startLevel_i'],
                'weight' => $event['weight_i'],
                'prize' => $event['rewardItem_a'],
                'info' => $event['info_s'],
            ];

            Event::create($data);
        }

        return redirect()->action('Admin\EventsController@getIndex');
    }
}
