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
        $lifeCycle = ConfigRedis::get('life_cycle');
        $length = count($events);
        $newEvents = array();
        $now = time();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->created_at + $lifeCycle) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode($newEvents))
            ->expire('user_event:' . $userId, $lifeCycle)
            ->execute();

        return $newEvents;
    }

    public static function addEvent($userId, array $data)
    {
        $events = json_decode(Redis::get('user_event:' . $userId));
        $lifeCycle = ConfigRedis::get('life_cycle');
        $length = count($events);
        $dataLength = count($data);
        $newEvents = array();
        $now = time();

        for ($i = 0; $i < $length; $i++) {
            if (($events[$i]->created_at + $lifeCycle) > $now) {
                $newEvents[] = $events[$i];
            }
        }

        for ($i = 0; $i < $dataLength; $i++) {
            $data[$i]['is_open'] = 0;
            $data[$i]['host_event_id'] = 0;
            $data[$i]['created_at'] = $now;
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode(array_merge($newEvents, $data)))
            ->expire('user_event:' . $userId, $lifeCycle)
            ->execute();
    }

    public static function open($userId, array $data): int
    {
        if (! User::free($userId)) {
            return 0;
        }

        $hostEventId = -1;
        $events = json_decode(Redis::get('user_event:' . $userId));
        $lifeCycle = ConfigRedis::get('life_cycle');
        $length = count($events);
        $found = false;

        for ($i = 0; $i < $length; $i++) {
            if ($events[$i]->event_id == $data['event_id']
                && $events[$i]->longitude == $data['longitude']
                && $events[$i]->latitude == $data['latitude']) {
                $found = true;

                if (! $events[$i]->is_open) {
                    $hostEventId = HostEvent::host($userId, $data['event_id']);
                    $events[$i]->is_open = 1;
                    $events[$i]->host_event_id = $hostEventId;
                }

                break;
            }
        }

        if (! $found) {
            $hostEventId = HostEvent::host($userId, $data['event_id']);
            $data['is_open'] = 1;
            $data['host_event_id'] = $hostEventId;
            $data['created_at'] = time();
            $events[] = $data;
        }

        Redis::pipeline()->set('user_event:' . $userId, json_encode($events))
            ->expire('user_event:' . $userId, $lifeCycle)
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
