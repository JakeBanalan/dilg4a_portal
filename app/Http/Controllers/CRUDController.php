<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Pusher\Pusher;

use App\Models\RICTUModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;


class CRUDController extends Controller
{
    const STATUS_DRAFT      = 1;
    const STATUS_RECEIVED   = 2;
    const STATUS_COMPLETED  = 3;
    const STATUS_RETURNED   = 4;
    const STATUS_RATED      = 5;
    public function post_complete(Request $req)
    {
        // Update the ICT request in the database
        RICTUModel::where('id', $req->input('id'))
            ->update([
                'completed_date' => $req->input('completed_date'),
                'ict_officer_remarks' => $req->input('recommendation'),
                'status_id' => self::STATUS_COMPLETED
            ]);


        // Fetch the users ID from the database
        $userId = RICTUModel::where('id', $req->input('id'))->first()->request_by;

        // Fetch the receiver's full name and id from the database
        $receiverId = RICTUModel::where('id', $req->input('id'))->first()->assign_ict_officer;
        $receiver = UserModel::selectRaw('
     users.id as id,
     CONCAT(users.first_name, " ", users.middle_name, " ", users.last_name) as receiverName,
     users.username')
            ->where('users.id', $receiverId)
            ->first();
        // ✅ Fetch CSS link dynamically based on the current month
        $currentMonth = date('m');
        $cssLink = DB::table('tbl_css_link')->where('month', $currentMonth)->value('link');
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

        $data = [
            'requester_id' => $userId,
            'receiverName' => $receiver->receiverName,
            'link' => $cssLink,
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

        // Fetch the user's full name from the database
        $userId = RICTUModel::where('id', $request->input('control_no_id'))->first()->request_by;
        // Fetch the receiver's full name from the database
        $receiverId = RICTUModel::where('id', $request->input('control_no_id'))->first()->assign_ict_officer;
        $receiver = UserModel::selectRaw('
        users.id as id,
        CONCAT(users.first_name, " ", users.middle_name, " ", users.last_name) as receiverName,
        users.username')
            ->where('users.id', $receiverId)
            ->first();


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
            'requester_id' => $userId,
            'receiverName' => $receiver->receiverName,
        ];

        // Trigger the event
        $pusher->trigger('received-ta-channel', 'received-ict-ta', $data);

        // Return a success response
        return response()->json(['message' => 'ICT request updated successfully.'], 200);
    }
}
