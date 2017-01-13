<?php

namespace App\Library\Event;

use App\Models\{HostEvent, User};
use App\Models\Event as EventModel;
use App\Library\Redis\{ConfigRedis, Redis};

class Event
{
    public static function all($userId): array
    {
        $events = json_decode(Redis::get('user_event:' . $userId));
        $length = count($events);
        $newEvents = array();
        $now = time();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->created + 172800) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode($newEvents))
            ->expire('user_event:' . $userId, 172800)
            ->execute();

        return $newEvents;
    }

    public static function addEvent($userId, array $data)
    {
        $events = json_decode(Redis::get('user_event:' . $userId));
        $length = count($events);
        $dataLength = count($data);
        $newEvents = array();
        $now = time();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->created + 172800) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        for ($i = 0; $i < $dataLength; $i++) {
            $data[$i]['created'] = $now;
            $data[$i]['is_open'] = 0;
            $data[$i]['host_event_id'] = 0;
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode(array_merge($newEvents, $data)))
            ->expire('user_event:' . $userId, 172800)
            ->execute();
    }

    public static function open($userId, array $data): int
    {
        if (! User::free($userId)) {
            return 0;
        }

        $hostEventId = HostEvent::host($userId, $data['event_id']);

        $events = json_decode(Redis::get('user_event:' . $userId));
        $length = count($events);

        for ($i = 0; $i < $length; $i++) {
            if ($events[$i]->event_id == $data['event_id']
                && $events[$i]->longitude == $data['longitude']
                && $events[$i]->latitude == $data['latitude']) {
                $events[$i]->is_open = 1;
                $events[$i]->host_event_id = $hostEventId;
            }
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode($events))
            ->expire('user_event:' . $userId, 172800)
            ->execute();

        return $hostEventId;
    }

    public static function random($userId, $count): array
    {
        if ($count >= 6) {
            return [];
        }

        return ['events' => EventModel::random(Redis::hget('user:'.$userId, 'level'), $count)];
    }

    public static function delete($userId, $hostEventId)
    {
        HostEvent::where('id', $hostEventId)->delete();

        $events = json_decode(Redis::get('user_event:' . $userId));
        $length = count($events);
        $newEvents = array();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->host_event_id) != $hostEventId) {
                $newEvents[] = $events[$i];
            }
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode($newEvents))
            ->expire('user_event:' . $userId, 172800)
            ->execute();
    }
}
