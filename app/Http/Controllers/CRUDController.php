<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RICTUModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


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
        return response()->json(['message' => 'Update successfully']);
    }
    
    public function post_received_ict_request(Request $request)
    {
        RICTUModel::where('id', $request->input('control_no_id'))
            ->update([
                'received_date' => DB::raw('CURRENT_TIMESTAMP'),
                'assign_ict_officer' => $request->input('cur_user'),
                'status_id' => self::STATUS_RECEIVED
            ]);
        return response()->json(['message' => 'Update successfully']);
    }
}
