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

    public function dashboardEventData(Request $request)
    {
        // Get the start and end of the current month
        $startOfMonth = now()->startOfMonth()->format('Y-m-d H:i:s');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d H:i:s');

        // Get the user ID from the request
        $userId = $request->input('userId');

        // Define the base query
        $query = CalendarModel::select(
            'events.id',
            'events.office',
            'events.title',
            'events.personnalevent',
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
            ->whereBetween('events.start', [$startOfMonth, $endOfMonth]);

        // Apply filters based on user ID
        if ($userId) {
            $query->where('events.postedby', $userId)
                ->where('events.personnalevent', 1);
        } else {
            $query->where('events.personnalevent', 0);
        }

        // Execute the query and transform the results
        $EventData = $query->get();
        $eventArray = $EventData->map(function ($event) {
            $event->remarks = array_map('trim', explode(',', $event->remarks));
            return $event;
        });

        return response()->json($eventArray);
    }
    public function fetchEventData(Request $request)
    {
        $officeFilter = $request->input('office');
        $showMyPersonalEvents = $request->input('personnalevent');
        $userId = $request->input('user_id');

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
        if ($showMyPersonalEvents) {
            // Show personal events for the specific user
            $EventData = $EventData->where(function ($query) use ($userId, $officeFilter) {
                $query->where('events.postedby', $userId)
                    ->where('events.personnalevent', 1);

                // Include non-personal events for the selected offices
                if ($officeFilter === '0') {
                    // Include all offices
                    $query->orWhere('events.personnalevent', 0);
                } elseif ($officeFilter !== '') {
                    // Filter by specific offices
                    $officeFilterArray = explode(',', $officeFilter);
                    $query->orWhere(function ($q) use ($officeFilterArray) {
                        $q->whereIn('events.office', $officeFilterArray)
                            ->where('events.personnalevent', 0);
                    });
                }
            });
        } else {
            // Only show non-personal events
            if ($officeFilter === '0') {
                // Include all offices
                $EventData = $EventData->where('events.personnalevent', 0);
            } elseif ($officeFilter !== '') {
                // Filter by specific offices
                $officeFilterArray = explode(',', $officeFilter);
                $EventData = $EventData->whereIn('events.office', $officeFilterArray)
                    ->where('events.personnalevent', 0);
            } else {
                // Only show non-personal events when no offices are selected
                $EventData = $EventData->where('events.personnalevent', 0);
            }
        }

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
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'venue' => $request->input('venue'),
                'remarks' => $request->input('remarks'),
                'enp' => $request->input('enp'),
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s')
            ]);
    }

    public function PostUpdateDragDrop(Request $request)
    {
        $start = Carbon::parse($request->input('start'));
        $end = Carbon::parse($request->input('end'));

        CalendarModel::where('id', $request->input('id'))
            ->update([
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s')
            ]);
    }

    public function deleteEvent(Request $request)
    {
        $id = $request->input('id');

        DB::table('events')->where('id', $id)->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
