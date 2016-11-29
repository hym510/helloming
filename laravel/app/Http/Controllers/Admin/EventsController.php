<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventsRequest;
use App\Models\{Chest, Event, Mine, Monster};

class EventsController extends Controller
{
    protected function typeName(array $event): array
    {
        $data = array();

        switch ($event['type']) {
            case 'monster':
                $data = Monster::find($event['monster_id'])->toArray();
                $event['id'] = $data['id'];
                unset($event['mine_id']);
                unset($event['chest_id']);
                break;
            case 'mine':
                $data = Mine::find($event['mine_id'])->toArray();
                $event['id'] = $data['id'];
                unset($event['monster_id']);
                unset($event['chest_id']);
                break;
            case 'chest':
                $data = Chest::find($event['chest_id'])->toArray();
                $event['id'] = $data['id'];
                unset($event['mine_id']);
                unset($event['monster_id']);
                break;
        }

        return $event;
    }

    public function getIndex()
    {
        return view('admin.events.index', ['events' => Event::get()]);
    }

    public function getAdd()
    {
        return view('admin.events.edit');
    }

    public function getEdit($eventId)
    {
        return view('admin.events.edit', [
            'event' => Event::findOrFail($eventId),
            'prize' => json_encode($event->prize)
        ]);
    }

    public function postStore(EventsRequest $request)
    {
        Event::create($this->typeName($request->inputData()));

        return redirect()->action('Admin\EventsController@getIndex');
    }

    public function postUpdate(EventsRequest $request, $eventId)
    {
        Event::where('id', $eventId)
            ->update($this->typeName($request->inputData()));

        return redirect()->action('Admin\EventsController@getIndex');
    }

    public function getDelete($eventId)
    {
        Event::where('id', $eventId)->delete();

        return redirect()->action('Admin\EventsController@getIndex');
    }
}
