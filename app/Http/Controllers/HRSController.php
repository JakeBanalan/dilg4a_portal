<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HRSModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class HRSController extends Controller
{
    public function getActiveAccounts()
    {
        return response()->json(
            HRSModel::select(
                HRSModel::raw('COUNT(*) as total_accounts')
            )
                ->where('is_activated', 'YES')
                ->get()
        );
    }
}
