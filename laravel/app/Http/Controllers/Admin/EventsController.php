<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventsRequest;

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
        $event = $request->inputData();
        $event['prize'] = json_encode($event['prize']);
        switch ($request->type) {
            case 'monster':
                unset($event['mine_id']);
                unset($event['fortune_id']);
                break;
            case 'mine':
                unset($event['monster_id']);
                unset($event['fortune_id']);
                break;
            case 'fortune':
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
