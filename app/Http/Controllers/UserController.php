<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
use Laravel\Passport\HasApiTokens; // Import HasApiTokens trait



use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

 


    public function login(Request $request)
    {
        $hashPass = hash('sha256', $request->password);
        $user = User::where('username', $request->input('username'))
            ->where('password', $hashPass)
            ->first();
          
        if ($user) {
            $token = $user->createToken('auth-token')->plainTextToken;

            User::where('id',$user->id)
            ->update([
                'api_token' => $token
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'api_token' => $token,
                'user_role' => $user->user_role,
                'userId' => $user->id, 
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
            CONCAT(users.last_name," ", users.first_name," ",users.middle_name)  as name,
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
        $user = Auth::guard('api')->user();
        if ($user) {
            $user->tokens()->delete(); // Invalidate all user tokens
        }

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
