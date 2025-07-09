<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FundSourceModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FundSourceController extends Controller
{
    public function fetchFundSources()
    {
        return response()->json(
            FundSourceModel::all()
        );
    }
}
