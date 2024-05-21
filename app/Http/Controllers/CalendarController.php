<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CalendarModel;
use App\Models\UserModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CalendarController extends Controller
{

    public function fetchEventData()
    {

        $EventData = CalendarModel::select(
            'events.id',
            'events.office',
            'events.title',
            'pmo.DIVISION_COLOR as color',
            'events.description',
            'events.venue',
            'events.enp',
            'events.postedby',
            'events.posteddate',
            'events.realenddate',
            'events.cancelflag',
            'events.status',
            'events.isRead',
            'events.isGenerateRO',
            'events.remarks',
            'events.comments',
            'events.priority',
            'events.program',
            'events.is_new',
            'events.code_series',
            'events.event_reminder',
            'events.isSent',
            DB::raw("DATE_FORMAT(events.start, '%Y-%m-%dT%H:%i:%s') as start"),
            DB::raw("DATE_FORMAT(events.end, '%Y-%m-%dT%H:%i:%s') as end"),
            DB::raw("CONCAT(users.last_name, ', ', users.first_name) AS fname")
        )
            ->leftjoin('pmo', 'pmo.id', '=', 'events.office')
            ->leftjoin('users', 'users.id', '=', 'events.postedby')
            ->get();

        return response()->json($EventData);
    }

    public function PostEventData(Request $request)
    {
        $postEvent = new CalendarModel([
            // 'office' => $request->input('office'),
            'title' => $request->input('title'),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            'description' => $request->input('description'),
            // 'venue' => $request->input('venue'),
            'enp' => $request->input('enp'),
            // 'postedby' => $request->input('userid'),
            // 'posteddate' => Carbon::now(),
            // 'remarks' => $request->input('remarks'),


        ]);

        $postEvent->save();
        // dd($postEvent);

    }

    public function PostUpdateEvent(Request $request)
    {
        CalendarModel::where('id', $request->input('id'))
            ->update([
                'title' => $request->input('title'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'description' => $request->input('description'),
                // 'venue' => $request->input('venue'),
                'enp' => $request->input('enp'),
                // 'postedby' => $request->input('userid'),
                // 'posteddate' => Carbon::now(),
                // 'remarks' => $request->input('remarks'),
            ]);
    }
}
