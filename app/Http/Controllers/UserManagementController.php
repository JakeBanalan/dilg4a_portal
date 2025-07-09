<?php

namespace App\Http\Controllers;

use App\Models\CityMunModel;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
use App\Models\UserModel;
use App\Models\ProvinceModel;
use App\Models\OfficeModel;
use Illuminate\Support\Facades\Cache;

use Laravel\Passport\HasApiTokens; // Import HasApiTokens trait



use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function fetchEmployeeData()
    {
        $userData = Cache::remember('employees:all', 3600, function () {
            return UserModel::selectRaw('
            users.id as id,
            users.employee_no as employee_no,
            users.first_name as first_name,
            users.last_name as last_name,
            users.middle_name as middle_name,
            pmo.pmo_title as pmo_title,
            pmo.id as pmo_id,
            tblposition.position_title as position_title,
            users.email as email,
            users.ext_name as ext_name,
            users.gender as gender,
            users.birthdate as birthdate,
            users.contact_details as contact_details,
            users.employment_status as employment_status,
            users.code as code,
            users.user_role as user_role,
            users.username as username,
            users.password as password,
            tbl_province.province as province,
            tbl_office.office as office,
            tbl_citymun.citymun as citymun,
            CONCAT(users.first_name, " ", users.middle_name, " ", users.last_name) as name
        ')
                ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
                ->leftJoin('tblposition', 'tblposition.POSITION_C', '=', 'users.position_id')
                ->leftJoin('tbl_province', 'tbl_province.id', '=', 'users.province')
                ->leftJoin('tbl_office', 'tbl_office.id', '=', 'users.office')
                ->leftJoin('tbl_citymun', 'tbl_citymun.id', '=', 'users.citymun')
                ->get();
        });

        return response()->json($userData);
    }

    public function getProvinces()
    {
        $query = ProvinceModel::selectRaw('
        tbl_province.id,
        tbl_province.province
                    ');
        $data = $query->get();
        return response()->json($data);
    }


    public function getCityMun(request $request)
    {
        $query = CityMunModel::selectRaw('
        tbl_citymun.id,
        tbl_citymun.province_id,
        tbl_citymun.citymun
        ')
            ->WHERE('tbl_citymun.province_id', $request->provID);
        $data = $query->get();
        return response()->json($data);
    }

    public function getAllCityMun()
    {
        $query = CityMunModel::selectRaw('
        tbl_citymun.id,
        tbl_citymun.province_id,
        tbl_citymun.citymun
        ');
        $data = $query->get();
        return response()->json($data);
    }

    public function getOffice(request $request)
    {
        $query = OfficeModel::selectRaw('
        tbl_office.id,
        tbl_office.office
                    ');
        $data = $query->get();
        return response()->json($data);
    }

    public function PostUser(request $request)
    {
        $hashedPassword = hash('sha256', $request->password);

        $PostUser = new UserModel([
            'id'                   => null,
            'pmo_id'                => $request->pmo,
            'employee_no'           => $request->employee_no,
            'position_id'             => $request->position_id,
            'province'               => $request->province,
            'citymun'               => $request->citymun,
            'office'              => $request->office,
            'section'               => $request->section,
            'division'              => $request->division,
            'employment_status'      => $request->employment_status,
            'first_name'           => $request->first_name,
            'middle_name'         => $request->middle_name,
            'last_name'         => $request->last_name,
            'ext_name'         => $request->ext_name,
            'birthdate'         => $request->birthdate,
            'gender'            => $request->gender,
            'contact_details'         => $request->contact_details,
            'email'             => $request->email,
            'username'         => $request->username,
            'password'         => $hashedPassword,
            'is_activated'         => 'Yes',
            'user_role'         => 'user',
            'allowed_menus' => json_encode($request->allowedMenus), // Save allowed menus as JSON
            'module_access' => $request->module_access, // Save module access JSON
        ]);
        // dd($PostUser);
        $PostUser->save();

        Cache::forget('employees:all');
        // return response()->json($PostUser);
    }

    public function getUserDetails($id)
    {
        $query = UserModel::selectRaw('
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
            users.province,
            users.citymun,
            users.office,
            users.section,
            users.division,
            users.position_id,
            users.module_access,
            pos.POSITION_TITLE as position,
            CONCAT(users.first_name," ", users.middle_name," ",users.last_name) as name
        ')
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->leftJoin('tblposition as pos', 'pos.POSITION_C', '=', 'users.position_id')
            ->where('users.id', $id);

        $data = $query->first(); // Use first() instead of get() to retrieve a single result
        return response()->json($data);
    }

    public function fetchUserOfficeCount()
    {
        $query = UserModel::selectRaw('
        users.office, COUNT(*) as office_count')
            ->leftJoin('tbl_office as o', 'o.id', '=', 'users.office')
            ->whereNull('users.office')
            ->groupBy('o.id');
        $data = $query->get();
        return response()->json($data);
    }

    public function updateUserSidebar(Request $request)
    {
        $user = UserModel::find($request->userId);
        if ($user) {
            $user->module_access = $request->module_access; // Save module_access as JSON string
            $user->save();
            return response()->json(['message' => 'Sidebar items updated successfully.']);
        }
        return response()->json(['message' => 'User not found.'], 404);
    }
}
