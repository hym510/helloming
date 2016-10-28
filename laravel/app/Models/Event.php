<?php

namespace App\Models;

class Event extends Model
{
    protected $table = 'events';

    public static function random(): array
    {
        $events = static::orderByRaw('RAND()')
            ->limit(6)
            ->get([
                'id', 'type', 'monster_id',
                'mine_id', 'info'
            ])
            ->toArray();

        foreach ($events as &$event) {
            if ($event['type'] == 'monster') {
                $event['monster'] = Monster::find($event['monster_id'])->toArray();
            } elseif ($event['type'] == 'mine') {
                $event['mine'] = Mine::find($event['mine_id'])->toArray();
            }
        }

        return $events;
    }
}
