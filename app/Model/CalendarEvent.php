<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{

    protected $fillable = [
        'event_name',
        'event_start',
        'event_end'
    ];
}
