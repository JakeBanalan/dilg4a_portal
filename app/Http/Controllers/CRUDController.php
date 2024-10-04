<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Pusher\Pusher;

use App\Models\RICTUModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CRUDController extends Controller
{
    const STATUS_DRAFT      = 1;
    const STATUS_RECEIVED   = 2;
    const STATUS_COMPLETED  = 3;
    const STATUS_RETURNED   = 4;
    const STATUS_RATED      = 5;
    public function post_complete(Request $req)
    {

        RICTUModel::where('id', $req->input('id'))
            ->update([
                'completed_date' => $req->input('completed_date'),
                'ict_officer_remarks' => $req->input('recommendation'),
                'status_id' => self::STATUS_COMPLETED
            ]);
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        // Define the data to send with the notification
        $data = [
            'ict_options' => $req->input('ict_options') // Include additional data as needed
        ];

        // Trigger the event
        $pusher->trigger('completed-ta-channel', 'completed-ict-ta', $data);

        // Return a success response
        return response()->json(['message' => 'ICT request updated successfully.'], 200);
    }

    public function post_received_ict_request(Request $request)
    {
        // Update the ICT request in the database
        RICTUModel::where('id', $request->input('control_no_id'))
            ->update([
                'received_date' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
                'started_date' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
                'assign_ict_officer' => $request->input('cur_user'),
                'status_id' => self::STATUS_RECEIVED
            ]);

        // Send notification via Pusher
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        // Define the data to send with the notification
        $data = [
            'ict_options' => $request->input('ict_options') // Include additional data as needed
        ];

        // Trigger the event
        $pusher->trigger('received-ta-channel', 'received-ict-ta', $data);

        // Return a success response
        return response()->json(['message' => 'ICT request updated successfully.'], 200);
    }
}
