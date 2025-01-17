<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Models\CalendarModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CalendarController extends Controller
{

    public function dashboardEventData()
    {
        // Get the start and end of the current month
        $startOfMonth = now()->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d H:i:s');

        $EventData = CalendarModel::select(
            'events.id',
            'events.office',
            'events.title',
            'events.color',
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
            DB::raw("DATE_FORMAT(events.start, '%Y-%m-%d %H:%i:%s') as start"),
            DB::raw("DATE_FORMAT(events.end, '%Y-%m-%d %H:%i:%s') as end"),
            DB::raw("CONCAT(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS fname")
        )
            ->leftjoin('pmo', 'pmo.id', '=', 'events.office')
            ->leftjoin('users', 'users.id', '=', 'events.postedby')
            ->whereBetween('events.start', [$startOfMonth, $endOfMonth]) // Filter events for the current month
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

        return response()->json($eventArray);
    }
    public function fetchEventData(Request $request)
    {
        $officeFilter = $request->input('office');
        $showMyPersonalEvents = $request->input('personnalevent');
        $userId = auth()->id();

        $EventData = CalendarModel::select(
            'events.id',
            'events.personnalevent',
            'events.office',
            'events.title',
            'events.color',
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
            DB::raw("DATE_FORMAT(events.start, '%Y-%m-%d %H:%i:%s') as start"),
            DB::raw("DATE_FORMAT(events.end, '%Y-%m-%d %H:%i:%s') as end"),
            DB::raw("CONCAT(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS fname")
        )
            ->leftJoin('pmo', 'pmo.id', '=', 'events.office')
            ->leftJoin('users', 'users.id', '=', 'events.postedby');

        // Combine conditions for "All Offices" and "My Personal Events"
        $EventData = $EventData->where(function ($query) use ($officeFilter, $showMyPersonalEvents, $userId) {
            if ($officeFilter === '0') {
                // Include all offices
                $query->orWhere('events.office', '!=', null);
            } else {
                // Filter by specific offices
                $officeFilterArray = explode(',', $officeFilter);
                $query->whereIn('events.office', $officeFilterArray);
            }

            if ($showMyPersonalEvents) {
                // Include personal events or events posted by the user
                $query->orWhere('events.personnalevent', 1)
                    ->orWhere('events.postedby', $userId);
            }
        });

        $EventData = $EventData->get();

        // Transform remarks field
        $eventArray = [];
        foreach ($EventData as $event) {
            $event->remarks = array_map('trim', explode(',', $event->remarks));
            $eventArray[] = $event;
        }

        return response()->json($eventArray);
    }



    public function PostEventData(Request $request)
    {
        // dd($request->all());
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Ensure remarks is an array before calling implode
            $remarks = is_array($request->input('remarks')) ? $request->input('remarks') : explode(',', $request->input('remarks'));

            // Create new CalendarModel record with data from the request
            $postEvent = new CalendarModel([
                'office'        => $request->input('office'),
                'title'         => $request->input('title'),
                'color'         => $request->input('color'),
                'start'         => $request->input('start'),
                'end'           => $request->input('end'),
                'description'   => $request->input('description'),
                'venue'         => $request->input('venue'),
                'enp'           => $request->input('enp'),
                'postedby'      => $request->input('postedby'),
                'remarks'       => implode(',', $remarks), // Use implode safely
                'personnalevent' => $request->input('personnalevent'), // Add the personnalEvent field
            ]);

            // Save the new event to the database
            $postEvent->save();
            // Commit the transaction
            DB::commit();

            // Optionally, return a response or the saved event
            return response()->json([
                'message' => 'Event created successfully!',
                'event' => $postEvent
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollback();

            // Optionally, return a response with the error message
            return response()->json([
                'message' => 'Failed to create event. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function PostUpdateEvent(Request $request)
    {
        $start = Carbon::parse($request->input('start'));
        $end = Carbon::parse($request->input('end'));

        CalendarModel::where('id', $request->input('id'))
            ->update([
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s')
            ]);
    }
}
