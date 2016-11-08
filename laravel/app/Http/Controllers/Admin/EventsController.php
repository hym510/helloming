<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventsRequest;
use App\Models\{Chest, Event, Mine, Monster};

class EventsController extends Controller
{
    public function getIndex()
    {
        $events = Event::when(request('keyword'), function ($q) {
            return $q->where('type', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.events.index', compact('events'));
    }

    public function getAdd()
    {
        return view('admin.events.edit');
    }

    public function getEdit($id)
    {
        $event = Event::findOrFail($id);

        return view('admin.events.edit', compact('event'));
    }

    public function postStore(EventsRequest $request)
    {
        $data = [];
        $event = $request->inputData();
        $event['prize'] = json_encode($event['prize']);
        switch ($request->type) {
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
        Event::create($event);

        return redirect()->action('Admin\EventsController@getIndex');
    }

    public function postUpdate(EventsRequest $request, $id)
    {
        $data = $request->inputData();
        $event = Event::findOrFail($id);
        $event->update($data);

        return redirect()->action('Admin\EventsController@getIndex');
    }

    public function getDelete($id)
    {
        Event::findOrFail($id)->delete();

        return redirect()->action('Admin\EventsController@getIndex');
    }
}
