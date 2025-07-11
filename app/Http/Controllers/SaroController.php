<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SaroModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaroController extends Controller
{
    public function fetchSaro()
    {
        return response()->json(
            SaroModel::all()
        );
    }
}
