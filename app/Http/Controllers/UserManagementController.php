<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
use App\Models\UserModel;
use Laravel\Passport\HasApiTokens; // Import HasApiTokens trait



use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function fetchEmployeeData()
    {
        $query = UserModel::selectRaw('
            users.id as id,
            users.employee_no as employee_no,
            users.first_name as first_name,
            users.last_name as last_name,
            users.middle_name as middle_name,
            pmo.pmo_title,
            pmo.id as pmo_id,
            pmo.pmo_title,
            tblposition.position_title,
            users.email as email,
            users.ext_name,
            users.gender,
            users.birthdate,
            users.contact_details,
            users.employment_status,
            users.code,
            users.user_role,
            users.username,
            users.password,
            CONCAT(users.first_name," ",users.middle_name," ", users.last_name)  as name
            ')
            ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->leftJoin('tblposition', 'tblposition.POSITION_C', '=', 'users.position_id');



        // Optionally, you can print the SQL query to check
        // dd($query->toSql());

        // Execute the query and return the result
        $userData = $query->get(); // Use first() instead of get() to retrieve a single result
        return response()->json($userData);
    }
}
