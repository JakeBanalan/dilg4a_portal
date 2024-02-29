<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;

use Hash;

class UserController extends Controller
{
    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required'
    //     ]);
    //     $email = $request->email;
    //     $password = $request->password;

    //     if (Auth::attempt(['email' => $email, 'password' => $password,])) {
    //         return response()->json(Auth::user(), 200);
    //     }
    //     throw ValidationException::withMessages([
    //         'email' => ['Username and password are incorrect.' . $password . '' . $email]
    //     ]);
    // }
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))
            ->where('password', $request->input('password'))
            ->first();

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'userId' => $user->id, // Assuming 'id' is the user ID field in your User model

            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed',
            ]);
        }
    }

    public function fetchUserData($userId)
    {
            $query = User::selectRaw('
            pmo.pmo_title,
            pmo.id,
            tblposition.position_title,
            users.name as name,
            users.email as email
            ')
            ->leftJoin('pr', 'pr.action_officer', '=', 'users.id')
            ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->leftJoin('tblposition', 'tblposition.POSITION_C', '=', 'users.position_id')
            ->where('users.id', $userId);



        // Optionally, you can print the SQL query to check
        // dd($query->toSql());

        // Execute the query and return the result
        $userData = $query->first(); // Use first() instead of get() to retrieve a single result
        return response()->json($userData);
    }








    public function logout()
    {
        Auth::logout();
    }
}
