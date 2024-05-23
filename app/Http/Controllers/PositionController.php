<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PositionModel;
use App\Models\UserModel;
use Laravel\Passport\HasApiTokens; // Import HasApiTokens trait



use Illuminate\Support\Facades\Hash;

class PositionController extends Controller
{
    public function getPosition()
    {
        $query = PositionModel::selectRaw('
        tblposition.POSITION_C,
        tblposition.POSITION_TITLE
                    ');
        $data = $query->get();
        return response()->json($data);
    }
}
