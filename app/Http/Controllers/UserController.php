<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens; // Import HasApiTokens trait


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

            User::where('id', $user->id)
                ->update([
                    'api_token' => $token
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'api_token' => $token,
                'user_role' => $user->user_role,
                'userId' => $user->id,
                'module_access' => $user->module_access, // Include module_access
                'isUpdatedPassword' => $user->isUpdatedPassword,
                'birthdate' => $user->birthdate, // Add birthdate to the response
                'name' => $user->first_name . ' ' . $user->last_name // Add full name to the response
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
            users.id as user_id,
            pmo.pmo_title,
            pmo.id,
            DIVISION_COLOR,
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

    public function fetchAllUsers()
    {
        $query = User::selectRaw('
        users.id,
        pmo.id as pmo_id,
        DATE_FORMAT(users.birthdate, "%M %d %Y") as birthdate,
        CONCAT(users.last_name," ", users.first_name," ",users.middle_name)  as name,
        users.email as email
        ')
            ->leftJoin('pr', 'pr.action_officer', '=', 'users.id')
            ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->leftJoin('tblposition', 'tblposition.POSITION_C', '=', 'users.position_id')
            ->distinct('users.id'); // Use distinct to remove duplicates

        $allUsers = $query->get(); // Use get() to retrieve all results
        return response()->json($allUsers);
    }

    public function getUserDetails($id)
    {
        $user = Cache::remember("user:{$id}:details", 3600, function () use ($id) {
            return User::selectRaw('
            users.id as id,
            users.last_name,
            users.middle_name,
            users.first_name,
            users.ext_name,
            users.gender,
            users.birthdate,
            users.contact_details,
            users.email,
            users.employment_status,
            users.employee_no,
            users.username,
            users.user_role,
            users.pmo_id,
            users.position_id,
            p.pmo_title as office,
            pos.POSITION_TITLE as position,
            CONCAT(users.first_name," ", users.middle_name," ",users.last_name) as name
        ')
                ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
                ->leftJoin('tblposition as pos', 'pos.POSITION_C', '=', 'users.position_id')
                ->where('users.id', $id)
                ->first();
        });

        return response()->json($user);
    }

    public function getGenderEmpStatus()
    {
        $employmentMap = [
            '1' => 'Permanent',
            '2' => 'Contract of Service',
            '3' => 'Job Order',
            '4' => 'Consultant'
        ];

        $users = User::select('gender', 'employment_status')->get();

        // Map employment status and gender values
        $users->transform(function ($user) use ($employmentMap) {
            return [
                'gender' => $user->gender === 'M' ? 'Male' : ($user->gender === 'F' ? 'Female' : 'Unknown'),
                'employment_status' => $employmentMap[$user->employment_status] ?? 'Unknown'
            ];
        });

        return response()->json($users);
    }


    public function updateUserDetails(Request $request)
    {
        // Validate the incoming request
        // $request->validate([
        //     'id' => 'required|integer',
        //     'employee_no' => 'nullable|string',
        //     'pmo_id' => 'nullable|integer',
        //     'position_id' => 'nullable|integer',
        //     'province' => 'nullable|string',
        //     'city' => 'nullable|string',
        //     'barangay' => 'nullable|string',
        //     'employment_status' => 'nullable|string',
        //     'first_name' => 'nullable|string',
        //     'middle_name' => 'nullable|string',
        //     'last_name' => 'nullable|string',
        //     'ext_name' => 'nullable|string',
        //     'birthdate' => 'nullable|date',
        //     'gender' => 'nullable|string',
        //     'contact_details' => 'nullable|string',
        //     'email' => 'nullable|string|email',
        //     'username' => 'nullable|string',
        // ]);

        // Hash the password if it is provided
        // Check if input password is provided and not empty
        if (!empty($request->password)) {
            $hashedPassword = hash('sha256', $request->password);
        } else {
            // If password is not provided or empty, retrieve the existing hashed password
            $existingUser = User::find($request->id);
            $hashedPassword = $existingUser->password;
        }

        // Update the user record
        User::where('id', $request->id)
            ->update([
                'employee_no' => $request->employee_no,
                'pmo_id'            => $request->pmo_id,
                'position_id'             => $request->position_id,
                'office'              => $request->office,
                'province'               => $request->province,
                'citymun'               => $request->citymun,
                'division'              => $request->division,
                'section'        => $request->section,
                'isUpdatedPassword' => 1,
                'employment_status'      => $request->employment_status,
                'first_name'           => $request->first_name,
                'middle_name'         => $request->middle_name,
                'last_name'         => $request->last_name,
                'ext_name'         => $request->ext_name,
                'birthdate'         => $request->birthdate,
                'gender'         => $request->gender,
                'contact_details'         => $request->contact_details,
                'email'         => $request->email,
                'username'         => $request->username,
                'password' => $hashedPassword,

            ]);

        return response()->json(['message' => 'User details updated successfully']);
    }



    public function logout()
    {
        $user = User::find(Auth::id());
        if ($user) {
            $user->tokens()->delete(); // Invalidate all user tokens
        }

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
