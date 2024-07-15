<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CalendarModel;
use App\Models\UserModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CalendarController extends Controller{

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
            DB::raw("DATE_FORMAT(events.start, '%Y-%m-%d') as start"),
            DB::raw("DATE_FORMAT(events.end, '%Y-%m-%d') as end"),
            DB::raw("CONCAT(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS fname")
            )
            ->leftjoin('pmo', 'pmo.id', '=', 'events.office')
            ->leftjoin('users', 'users.id', '=', 'events.postedby')
            ->get();

        // Initialize an array to store the transformed events
        $eventArray = [];

        // Iterate over each event and transform the remarks field
        foreach ($EventData as $event) {
            // Remove commas and split the remarks field into an array
            $event->remarks = array_map('trim', explode(',', $event->remarks));
            // Add the transformed event to the array
            $eventArray[] = $event;
}

            // dd($EventData);
        return response()->json($EventData);
    }

    public function PostEventData(Request $request)
    {
        $postEvent = new CalendarModel([
            'id'          => null,
            'office'      => $request->input('office'),
            'title'       => $request->input('title'),
            'color'       => $request->input('color'),
            'start'       => $request->input('start'),
            'end'         => $request->input('end'),
            'description' => $request->input('description'),
            'venue'       => $request->input('venue'),
            'enp'         => $request->input('enp'),
            'postedby'    => $request->input('postedby'),
            'remarks'     => $request->input('remarks')


        ]);

        $postEvent->save();
        // dd($postEvent);

    }

    public function PostUpdateEvent(Request $request)
    {
        CalendarModel::where('id', $request->input('id'))
            ->update([
                // 'office'      => $request->input('office'),
                'title'       => $request->input('title'),
                // 'color'       => $request->input('color'),
                'start'       => $request->input('start'),
                'end'         => $request->input('end'),
                'description' => $request->input('description'),
                'venue'       => $request->input('venue'),
                'enp'         => $request->input('enp'),
                // 'postedby'    => $request->input('postedby'),
                'remarks'     => $request->input('remarks')
            ]);

    }

    // public function post_create_event(Request $request)
    // {
    //     $rfq = new CalendarModel([
    //         'id'            => null,
    //         'office'         => $request->input('office'),
    //         'title'          => $request->input('title'),
    //         'color' => $request->input('color'),
    //         'start'  => $request->input('start'),
    //         'end'    =>  $request->input('end'),
    //         'description'    =>  $request->input('description'),
    //         'venue' => $request->input('venue'),
    //         'enp' => $request->input('enp'),
    //         'postedby' => $request->input('postedby'),
    //         'remarks' => $request->input('remarks')

    //     ]);





    //     $rfq->save();

    //     return response()->json(['message' => 'RFQ created successfully', 'sql_query' => $rfq], 201);
    // }
}

