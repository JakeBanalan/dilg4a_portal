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
            'pmo_id' => 1,
            'employee_no' => $request->employee_no,
            'position_id'             => $request->position_id,
            'province'               => $request->province,
            'citymun'               => $request->citymun,
            'office'              => $request->office,
            'section'        => $request->section,
            'division'              => $request->division,
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
            'password'         => $hashedPassword,
            'is_activated'         => 'Yes',
            'user_role'         => 'user',
        ]);
        // dd($postQP);
        $PostUser->save();
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
            pos.POSITION_TITLE as position,
            CONCAT(users.first_name," ", users.middle_name," ",users.last_name)  as name

            ')
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->leftJoin('tblposition as pos', 'pos.POSITION_C', '=', 'users.position_id')
            // ->leftJoin('tbl_province as prov', 'prov.id', '=', 'users.province')
            // ->leftJoin('tbl_office as ofc', 'ofc.id', '=', 'users.office')
            // ->leftJoin('tbl_citymun as ctm', 'ctm.id', '=', 'users.citymun')
            // ->leftJoin('tbl_section as sec', 'sec.id', '=', 'users.section')
            // ->leftJoin('tbl_division as div', 'div.id', '=', 'users.division')
            ->where('users.id', $id);
        $data = $query->first(); // Use first() instead of get() to retrieve a single result
        return response()->json($data);
    }

}
