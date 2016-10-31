<?php

namespace App\Models;

class Event extends Model
{
    protected $table = 'events';

    public static function random($level): array
    {
        $events = static::where('unlock_level', $level)
            ->orderByRaw('RAND()')
            ->limit(6)
            ->get([
                'id', 'type', 'level',
                'monster_id', 'mine_id', 'info'
            ])
            ->toArray();

        foreach ($events as &$event) {
            if ($event['type'] == 'monster') {
                $event['monster'] = Monster::find($event['monster_id'])->toArray();
                unset($event['mine_id']);
            } elseif ($event['type'] == 'mine') {
                $event['mine'] = Mine::find($event['mine_id'])->toArray();
                unset($event['monster_id']);
            }
        }

        return $events;
    }
}
