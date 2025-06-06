<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CalendarEvent;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            /*
             * Note : the column must be with these exactly name (id, title, start, end) to render them in the calendar
             * */
            $data = CalendarEvent::whereDate('event_start', '>=', $request->start)
                ->whereDate('event_end',   '<=', $request->end)
                ->select('id', 'event_name as title', 'event_start as start', 'event_end as end')->get();
            return response()->json($data);
        }
        return 'False Must Be Through an ajax Request';
    }

    public function calendarEvents(Request $request)
    {
        if ($request->ajax()) {
            switch ($request->type) {
                case 'create':
                    $event = CalendarEvent::create([
                        'event_name' => $request->event_name,
                        'event_start' => $request->event_start,
                        'event_end' => $request->event_end,
                    ]);
                    return response()->json($event);
                    break;

                case 'show':
                    $event = CalendarEvent::where('id', '=', $request->id)
                        ->select('id', 'event_name as title', 'event_start as start', 'event_end as end')->first();
                    return response()->json($event);
                    break;

                case 'edit':
                    $event = CalendarEvent::find($request->id)->update([
                        'event_name' => $request->event_name,
                        'event_start' => $request->event_start,
                        'event_end' => $request->event_end,
                    ]);
                    return response()->json($event);
                    break;

                case 'delete':
                    $event = CalendarEvent::find($request->id)->delete();
                    return response()->json($event);
                    break;

                case 'clear':
                    $events = CalendarEvent::all();
                    if ($events->isNotEmpty()) {
                        foreach($events as $event) {
                            $event->delete();
                        }
                    }
                    return response()->json(['success' => trans('admin.event-cleared-successfully')]);
                    break;

                default:
                    # ...
                    break;
            }
        }
        return 'False Must Be Through an ajax Request';
    }


}
