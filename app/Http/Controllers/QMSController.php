<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QMSModel;
use App\Models\UserModel;
use App\Models\QPModel;
use App\Models\QOPModel;
use App\Models\QOPRModel;
use App\Models\QOPFrequencyModel;
use App\Models\QGAModel;
use App\Models\QMSHistoryModel;
use App\Models\POProcessOwnerModel;



use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class QMSController extends Controller
{
    public function fetchProcessOwner()
    {
        $ProcessOwner = QMSModel::select(
            'tbl_qms_process_owners.id',
            'tbl_qms_process_owners.emp_id',
            'tbl_qms_process_owners.date_created',
            'tbl_qms_process_owners.created_by',
            'users.first_name',
            'users.last_name',
            'tblposition.position_title',
            'pmo.pmo_title',
            'users.contact_details',
            'users.email',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")

        )
            ->leftjoin('users', 'users.id', '=', 'tbl_qms_process_owners.emp_id')
            ->leftjoin('tblposition', 'tblposition.position_C', '=', 'users.position_id')
            ->leftjoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->get();

        return response()->json($ProcessOwner);
    }

    public function fetchPProcessOwner($id)
    {
        $ProcessOwner = QMSModel::select(
            'tbl_qms_process_owners.id',
            'tbl_qms_process_owners.emp_id',
            'users.first_name',
            'users.last_name',
            'tblposition.position_title',
            'pmo.pmo_title',
            'users.contact_details',
            'users.email',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fname")
        )
            ->leftJoin('users', 'users.id', '=', 'tbl_qms_process_owners.emp_id')
            ->leftJoin('tblposition', 'tblposition.position_C', '=', 'users.position_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->where('pmo.id', $id)
            ->get();

        // dd($ProcessOwner);
        return response()->json($ProcessOwner);
    }

    public function fetchProvinceUser($id)
    {
        $ProcessOwner = UserModel::select(
            'users.id',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fname"),
            'pmo.pmo_title',
        )
            ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->where('pmo.id', $id)
            ->get();

        // dd($ProcessOwner);
        return response()->json($ProcessOwner);
    }

    public function fetchPOProcessOwner($id)
    {
        $POprocessOwner = POProcessOwnerModel::select(
            'tbl_qms_po_process_owner.id',
            'tbl_qms_po_process_owner.qop_id',
            'tbl_qms_po_process_owner.pmo_id',
            'tbl_qms_po_process_owner.parent_p_owner',
            'tbl_qms_po_process_owner.po_process_owner',
            'pmo.pmo_title',
            'tbl_qms_po_process_owner.program_manager',
            'tbl_qms_po_process_owner.provincial_qmr',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS ppo_name"),
            DB::raw("CONCAT(user_qmr.first_name, ' ', user_qmr.last_name) AS qmr_name"),
            DB::raw("CONCAT(user_pm.first_name, ' ', user_pm.last_name) AS pm_name")
        )
            ->leftJoin('pmo as pmo', 'pmo.id', '=', 'tbl_qms_po_process_owner.pmo_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_qms_po_process_owner.po_process_owner')
            ->leftJoin('users as user_qmr', 'user_qmr.id', '=', 'tbl_qms_po_process_owner.provincial_qmr')
            ->leftJoin('users as user_pm', 'user_pm.id', '=', 'tbl_qms_po_process_owner.program_manager')
            ->where('tbl_qms_po_process_owner.qop_id', $id)
            ->get();

        return response()->json($POprocessOwner);

        //to change db structure from single row per qop to 6 row per qop and bind the to tbl_province loop upon creating qop
        //and hide depending on the selected coverage

        //still use user id as reference to the user
        //retain the use of parent_p_owner as the main process owner for easier binding of the process owner upon submission in the future
        //use the same process owner for the 6 province

    }

    public function AddPOProcessOwner(Request $request)
    {
        $ppoid = $request->input('ppoid');
        $id = $request->input('po');
        $ppo = $request->input('ppo');
        $pm = $request->input('pm');
        $qmr = $request->input('qmr');
        POProcessOwnerModel::where('id', $ppoid)
            ->update([
                'po_process_owner' => $ppo,
                'program_manager' => $pm,
                'provincial_qmr' => $qmr,
                'updated_at' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            ]);
    }
    public function DeletePOProcessOwner(request $request)
    {
        POProcessOwnerModel::where('id', $request->id)
            ->update([
                'po_process_owner' => null,
                'updated_at' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            ]);
    }
    public function fetchAllUser()
    {

        $ProcessOwner = QMSModel::select(
            'tbl_qms_process_owners.id',
            'tbl_qms_process_owners.emp_id',
            'tbl_qms_process_owners.date_created',
            'tbl_qms_process_owners.created_by',
            'users.first_name',
            'users.last_name',
            'tblposition.position_title',
            'pmo.pmo_title',
            'users.contact_details',
            'users.email',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")
        )
            ->leftJoin('users', 'users.id', '=', 'tbl_qms_process_owners.emp_id')
            ->leftJoin('tblposition', 'tblposition.position_C', '=', 'users.position_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'users.pmo_id')
            ->get();

        $powner = $ProcessOwner->pluck('emp_id')->toArray();

        $query = UserModel::select(
            'users.id',
            'users.pmo_id',
            'users.position_id',
            'users.employee_no',
            'users.last_name',
            'users.first_name',
            'users.middle_name',
            'users.ext_name',
            'users.gender',
            'users.birthdate',
            'users.contact_details',
            'users.email',
            'p.pmo_title',
            'pos.position_title',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")
        )
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->leftJoin('tblposition as pos', 'pos.POSITION_C', '=', 'users.position_id')
            ->whereNotIn('users.id', $powner)
            ->get();

        return response()->json($query);
    }

    public function DeleteProcessOwner(request $request)
    {
        QMSModel::where('emp_id', $request->id)

            ->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }

    public function addProcessOwner(request $request)
    {

        $postEvent = new QMSModel([
            'id'          => null,
            'emp_id'      => $request->id,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => null


        ]);
        // dd($postEvent);
        $postEvent->save();
    }

    public function postQualityProcedure(Request $request)
    {

        $postQP = new QPModel([
            'id'                   => null,
            'frequency_monitoring' => $request->input('frequency_monitoring'),
            'coverage'             => $request->input('coverage'),
            'office'               => $request->input('office'),
            'rev_no'               => $request->input('rev_no'),
            'EffDate'              => $request->input('EffDate'),
            'process_owner'        => $request->input('process_owner'),
            'qp_code'              => $request->input('qp_code'),
            'procedure_title'      => $request->input('procedure_title'),
            'created_by'           => $request->input('created_by'),
            'date_created'         => $request->input('date_created'),
        ]);
        // dd($postQP);
        $postQP->save();

        $createdId = $postQP->id;

        $pmoIds = [5, 10, 11, 9, 13, 12, 14];

        foreach ($pmoIds as $pmoId) {
            $po_process_owner = new POProcessOwnerModel([
                'qop_id'           => $createdId,
                'pmo_id'            => $pmoId,
                'parent_p_owner'   => $request->input('process_owner'),
                'po_process_owner' => null,
            ]);
            $po_process_owner->save();
        }

        return response()->json($postQP);
    }

    public function UpdateQualityProcedure(Request $request)
    {
        $id = $request->input('id');
        $EffDate = $request->input('EffDate');
        $frequency_monitoring = $request->input('frequency_monitoring');
        $coverage = $request->input('coverage');
        $office = $request->input('office');
        $rev_no = $request->input('rev_no');
        $process_owner = $request->input('process_owner');
        $qp_code = $request->input('qp_code');
        $procedure_title = $request->input('procedure_title');

        QPModel::where('id', $id)->update([
            'EffDate' => $EffDate,
            'frequency_monitoring' => $frequency_monitoring,
            'coverage' => $coverage,
            'office' => $office,
            'rev_no' => $rev_no,
            'process_owner' => $process_owner,
            'qp_code' => $qp_code,
            'procedure_title' => $procedure_title,
        ]);
    }

    public function fetchQualityProcedureAll()
    {
        $FetchQP = QPModel::select(
            'tbl_qop.id',
            'tbl_qop.frequency_monitoring',
            'tbl_qop.coverage',
            'tbl_qop.office',
            'tbl_qop.rev_no',
            'tbl_qop.EffDate',
            'tbl_qop.process_owner',
            'tbl_qop.qp_code',
            'tbl_qop.procedure_title',
            'tbl_qop.created_by',
            'tbl_qop.date_created',
            'qcoverage.coverage as coverage_name',
        )

            ->leftJoin('users', 'users.id', '=', 'tbl_qop.created_by')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'tbl_qop.coverage')
            // ->Where('tbl_qop.office', 'LIKE', '%' . $userOffice . '%')
            ->get();
        return response()->json($FetchQP);
    }
    public function fetchQualityProcedure($userId)
    {
        $fetchUser = UserModel::select(
            'users.username as username',
            'users.pmo_id',
            'p.pmo_title',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")
        )
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->where('users.id', $userId)
            ->first(); // Use first() instead of get() since you're expecting one user

        if (!$fetchUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $userOffice1 = $fetchUser->pmo_title;

        $query = QPModel::select(
            'tbl_qop.id',
            'tbl_qop.frequency_monitoring',
            'tbl_qop.coverage',
            'tbl_qop.office',
            'tbl_qop.rev_no',
            'tbl_qop.EffDate',
            'tbl_qop.process_owner',
            'tbl_qop.qp_code',
            'tbl_qop.procedure_title',
            'tbl_qop.created_by',
            'tbl_qop.date_created',
            'qcoverage.coverage as coverage_name'
        )
            ->leftJoin('users', 'users.id', '=', 'tbl_qop.created_by')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'tbl_qop.coverage');

        $query->where(function ($q) use ($userOffice1, $userId) {
            if (in_array($userOffice1, ['ORD', 'ORD-LEGAL', 'ORD-PLANNING', 'ORD-RICTU'])) {
                $q->where('tbl_qop.office', 'LIKE', '%ORD%');
            } elseif (in_array($userOffice1, ['LGMED', 'LGMED-MBRTG'])) {
                $q->where('tbl_qop.office', 'LIKE', '%LGMED%');
            } elseif (in_array($userOffice1, ['LGCDD', 'LGCDD-PDMU'])) {
                $q->where('tbl_qop.office', 'LIKE', '%LGCDD%');
            } elseif (in_array($userOffice1, ['CAVITE', 'LAGUNA', 'BATANGAS', 'RIZAL', 'QUEZON', 'LUCENA CITY'])) {
                $q->where('qcoverage.coverage', 'LIKE', '%Province%');
            } elseif (in_array($userOffice1, ['FAD', 'FAD'])) {
                $q->where('tbl_qop.office', 'LIKE', '%FAD%');
            }

            // OR: if user is the process owner
            $q->orWhere('tbl_qop.process_owner', $userId);
        });

        $FetchQP = $query->get();

        return response()->json($FetchQP);
    }

    public function fetchEntryData($id)
    {
        $FetchQP = QPModel::select(
            'tbl_qop.id',
            'tbl_qop.frequency_monitoring',
            'tbl_qop.coverage',
            'tbl_qop.office',
            'tbl_qop.rev_no',
            'tbl_qop.EffDate',
            'tbl_qop.process_owner',
            'tbl_qop.qp_code',
            'tbl_qop.procedure_title',
            'tbl_qop.created_by',
            'tbl_qop.date_created',
            'qcoverage.coverage as coverage_name',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS created_by")

        )
            ->leftJoin('users', 'users.id', '=', 'tbl_qop.created_by')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'tbl_qop.coverage')
            ->where('tbl_qop.id', $id)
            ->get();

        $QPArray = [];
        foreach ($FetchQP as $QP) {
            // Remove commas and split the remarks field into an array
            $QP->process_owner = array_map('trim', explode(',', $QP->process_owner));
            // Add the transformed event to the array
            $QPArray[] = $QP;
        }
        return response()->json($FetchQP);
    }

    public function fetchQualityObjectives($id)
    {

        $updateQP = QOPModel::select(
            'id',
            'qop_id',
            'objective',
            'created_by',
            'date_created',
            'target_percentage',
            'formula',
            'indicator_a',
            'indicator_b',
            'indicator_c',
            'indicator_d',
            'indicator_e',
        )
            ->where('qop_id', $id)
            ->get();

        // dd($postQP);
        // $postQP->save();
        return response()->json($updateQP);
    }

    public function UpdateQualityObjectives($id, $qoeID)
    {

        $updateQP = QOPModel::select(
            'id',
            'qop_id',
            'objective',
            'target_percentage',
            'formula',
            'indicator_a',
            'indicator_b',
            'indicator_c',
            'indicator_d',
            'indicator_e',
        )
            ->where('id', $id)
            ->where('qop_id', $qoeID)
            ->get();

        // dd($postQP);
        // $postQP->save();
        return response()->json($updateQP);
    }


    public function postUpdateQualityObjectives(request $request)
    {

        QOPModel::where('id',  $request->input('id'))
            ->where('qop_id',  $request->input('qop_id'))
            ->update([
                'objective'         => $request->input('objective'),
                'target_percentage' => $request->input('target_percentage'),
                'formula'           => $request->input('formula'),
                'indicator_a'       => $request->input('indicator_a'),
                'indicator_b'       => $request->input('indicator_b'),
                'indicator_c'       => $request->input('indicator_c'),
                'indicator_d'       => $request->input('indicator_d'),
                'indicator_e'       => $request->input('indicator_e'),
            ]);
    }


    public function postQualityObjectives(request $request)
    {

        $postQP = new QOPModel([
            'id'                   => null,
            'qop_id'               => $request->input('qop_id'),
            'objective'            => $request->input('quality_objective'),
            'target_percentage'    => $request->input('target'),
            'formula'              => $request->input('formula'),
            'indicator_a'          => $request->input('indicator_a'),
            'indicator_b'          => $request->input('indicator_b'),
            'indicator_c'          => $request->input('indicator_c'),
            'indicator_d'          => $request->input('indicator_d'),
            'indicator_e'          => $request->input('indicator_e'),
        ]);
        // dd($postQP);
        $postQP->save();
        // return response()->json($postQP);
    }

    public function DeleteQualityObjective(request $request)
    {
        QOPModel::where('id', $request->id)
            ->where('qop_id', $request->qop_id)
            ->delete();

        // return response()->json(['message' => 'Item deleted successfully']);
    }

    public function deleteQualityProcedure(request $request)
    {
        QPModel::where('id', $request->id)
            ->delete();

        QOPModel::where('qop_id', $request->id)
            ->delete();

        POProcessOwnerModel::where('qop_id', $request->id)
            ->delete();

        // return response()->json(['message' => 'Item deleted successfully']);
    }


    public function fetchQPdata($qp_code_id)
    {

        $FetchQP = QPModel::select(
            'tbl_qop.id',
            'tbl_qoe.id as qoe_id',
            'tbl_qop.frequency_monitoring',
            'tbl_qop.coverage',
            'tbl_qop.office',
            'tbl_qop.rev_no',
            'tbl_qop.EffDate',
            'tbl_qop.process_owner',
            'tbl_qop.qp_code',
            'tbl_qop.procedure_title',
            'tbl_qop.created_by',
            'tbl_qop.date_created',
            'qcoverage.coverage as coverage_name',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")

        )
            ->leftJoin('users', 'users.id', '=', 'tbl_qop.created_by')
            ->leftJoin('tbl_qoe', 'tbl_qoe.qop_id', '=', 'tbl_qop.id')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'tbl_qop.coverage')
            ->where('tbl_qop.id', $qp_code_id)
            ->get();
        return response()->json($FetchQP);
    }

    public function fetchMonthlyData($id, $qoe_id)
    {
        DB::enableQueryLog();

        // Assuming you have a model named QOPFrequencyModel that represents your table tbl_qoe_frequency_entry
        $monthlyData = QOPFrequencyModel::where('qop_entry_id', $id)
            ->where('qoe_id', $qoe_id)
            ->get(); // Execute the query to fetch all matching records

        // Get the latest executed query
        $query = DB::getQueryLog();
        $lastQuery = end($query)['query'];

        // If no data found, return a 404 response
        if ($monthlyData->isEmpty()) {
            return response()->json(['message' => 'Monthly data not found'], 404);
        }

        // Prepare an array to hold the transformed data
        $monthly = [];

        foreach ($monthlyData as $data) {
            // Transform the rate column from JSON to an associative array
            $rate = json_decode($data->rate, true);

            // Add quarter data to the array
            $monthly[] = [
                'id' => $data->id,
                'qop_entry_id' => $data->qop_entry_id,
                'qoe_id' => $data->qoe_id,
                'indicator' => $data->indicator,
                '01' => $rate['01'] ?? null,
                '02' => $rate['02'] ?? null,
                '03' => $rate['03'] ?? null,
                '04' => $rate['04'] ?? null,
                '05' => $rate['05'] ?? null,
                '06' => $rate['06'] ?? null,
                '07' => $rate['07'] ?? null,
                '08' => $rate['08'] ?? null,
                '09' => $rate['09'] ?? null,
                '10' => $rate['10'] ?? null,
                '11' => $rate['11'] ?? null,
                '12' => $rate['12'] ?? null,
            ];
        }

        // Return the quarter data array and log the SQL query
        return response()->json([
            'monthly' => $monthly,
            'sql_query' => $lastQuery // Include the SQL query in the response for debugging
        ]);
    }

    public function fetchQuarterData($id, $qoe_id)
    {
        DB::enableQueryLog();

        // Assuming you have a model named QOPFrequencyModel that represents your table tbl_qoe_frequency_entry
        $quarterData = QOPFrequencyModel::where('qop_entry_id', $id)
            ->where('qoe_id', $qoe_id)
            ->get(); // Execute the query to fetch all matching records

        // Get the latest executed query
        $query = DB::getQueryLog();
        $lastQuery = end($query)['query'];

        // If no data found, return a 404 response
        if ($quarterData->isEmpty()) {
            return response()->json(['message' => 'Quarter data not found'], 404);
        }

        // Prepare an array to hold the transformed data
        $quarters = [];

        foreach ($quarterData as $data) {
            // Transform the rate column from JSON to an associative array
            $rate = json_decode($data->rate, true);

            // Add quarter data to the array
            $quarters[] = [
                'id' => $data->id,
                'qop_entry_id' => $data->qop_entry_id,
                'qoe_id' => $data->qoe_id,
                'indicator' => $data->indicator,
                'Q1' => $rate['Q1'] ?? null,
                'Q2' => $rate['Q2'] ?? null,
                'Q3' => $rate['Q3'] ?? null,
                'Q4' => $rate['Q4'] ?? null,
            ];
        }

        // Return the quarter data array and log the SQL query
        return response()->json([
            'quarters' => $quarters,
            'sql_query' => $lastQuery // Include the SQL query in the response for debugging
        ]);
    }

    public function saveMonthlyData(Request $request)
    {
        $monthlyData = $request->monthlyData;
        $formData = $request->formData;

        $GA = [
            'is_gap_analysis' => $formData['is_gap_analysis'],
            'gap_analysis' => $formData['gap_analysis'],
        ];

        QGAModel::where('id', $formData['gap_id'])
            ->where('qop_id', $formData['qop_id'])
            ->where('qoe_id', $formData['gap_qoe_id'])
            ->update($GA);

        foreach ($monthlyData as $item) {
            $id = $item['id'] ?? null;

            // Validate if ID exists
            if (!$id) {
                return response()->json(['error' => 'ID is required for update'], 400);
            }

            // Prepare update data
            $updateData = [
                'rate' => json_encode([
                    "01" => $item['01'] ?? null,
                    "02" => $item['02'] ?? null,
                    "03" => $item['03'] ?? null,
                    "04" => $item['04'] ?? null,
                    "05" => $item['05'] ?? null,
                    "06" => $item['06'] ?? null,
                    "07" => $item['07'] ?? null,
                    "08" => $item['08'] ?? null,
                    "09" => $item['09'] ?? null,
                    "10" => $item['10'] ?? null,
                    "11" => $item['11'] ?? null,
                    "12" => $item['12'] ?? null,
                ]),
                'updated_at' => now(),
            ];

            // Update record in database
            $affectedRows = QOPFrequencyModel::where('id', $id)->update($updateData);

            // Optionally, handle response or error logic based on $affectedRows
        }

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function saveQuarterData(Request $request)
    {
        $quarterData = $request->quarterData;
        $formData = $request->formData;

        // if (!isset($formData['id'], $formData['is_gap_analysis'], $formData['gap_analysis'])) {
        //     return response()->json(['error' => 'Incomplete form data'], 400);
        // }

        $GA = [
            'is_gap_analysis' => $formData['is_gap_analysis'],
            'gap_analysis' => $formData['gap_analysis'],
        ];

        QGAModel::where('id', $formData['gap_id'])
            ->where('qop_id', $formData['qop_id'])
            ->where('qoe_id', $formData['gap_qoe_id'])
            ->update($GA);

        foreach ($quarterData as $item) {
            $id = $item['id'] ?? null;

            // Validate if ID exists
            if (!$id) {
                return response()->json(['error' => 'ID is required for update'], 400);
            }

            // Prepare update data
            $updateData = [
                'rate' => json_encode([
                    "Q1" => $item['Q1'] ?? null,
                    "Q2" => $item['Q2'] ?? null,
                    "Q3" => $item['Q3'] ?? null,
                    "Q4" => $item['Q4'] ?? null,
                ]),
                'updated_at' => now(),
            ];

            // Update record in database
            $affectedRows = QOPFrequencyModel::where('id', $id)->update($updateData);

            // Optionally, handle response or error logic based on $affectedRows
        }

        return response()->json(['message' => 'Data updated successfully']);
    }

    // public function ValidateReportEntry(Request $request)
    // {

    // }

    public function postReportEntry(Request $request)
    {
        // Determine the value of period based on the request
        $period = [];
        if ($request->frequency_monitoring == 'Monthly') {
            $period = [
                "01" => "",
                "02" => "",
                "03" => "",
                "04" => "",
                "05" => "",
                "06" => "",
                "07" => "",
                "08" => "",
                "09" => "",
                "10" => "",
                "11" => "",
                "12" => ""
            ];
        } elseif ($request->frequency_monitoring == 'Quarterly') {
            $period = [
                "01" => "",
                "02" => "",
                "03" => "",
                "04" => ""
            ];
        } elseif ($request->frequency_monitoring == 'Quarterly (Learning and Development)') {
            $period = [
                "01" => "",
                "02" => "",
                "03" => "",
                "04" => ""
            ];
        } else {
            return response()->json(['error' => 'Invalid report type.'], 400);
        }

        $userOffice = UserModel::select('id', 'office', 'province')->find($request->created_by);

        if (!$userOffice) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Create a new QOPRModel instance for the main record
        $postRS = new QOPRModel([
            'qop_id' => $request->qop_id,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => $request->created_by,
            'submitted_office' => $userOffice->province,
            'status' => '0',
            'qp_covered' => $request->qp_covered, // Assuming qp_covered is a JSON column
            'year' => $request->year
        ]);

        // Save the main record first
        $postRS->save();

        // gap_analysis
        // Fetch the created ID
        $createdId = $postRS->id;
        $createdOffice = $postRS->submitted_office;
        $qoe_ids = $request->qoe_id; // Assuming $request->qoe_id is an array [14, 15]
        $qop_id = $request->qop_id;

        $subHistory = new QMSHistoryModel([
            'qop_entry_id' => $createdId,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => $request->created_by,
            'status' => '0',
            'remarks' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Save the main record first
        $subHistory->save();
        // return response()->json($subHistory);


        foreach ($qoe_ids as $qoe_id) {
            $post_gap_analysis = new QGAModel([
                'qop_entry_id' => $createdId,
                'qop_id' => $qop_id,
                'qoe_id'   => $qoe_id,
            ]);
            // dd($post_gap_analysis);
            $post_gap_analysis->save();
        }

        // Check for existing frequency entries
        $existing = QOPFrequencyModel::whereIn('qoe_id', $qoe_ids)
            ->where('qop_id', $qop_id)
            ->where('office_entry_id', $createdOffice)
            ->exists();


        if ($existing) {
            // Safely fetch the latest entries scoped to current qop_id
            $lastEntry = QOPFrequencyModel::where('qop_id', $qop_id)
                ->orderByDesc('created_at')
                ->first();

            if ($lastEntry) {
                $lastEntryId = $lastEntry->qop_entry_id;

                $lastEntries = QOPFrequencyModel::where('qop_entry_id', $lastEntryId)->get();
                $grouped = $lastEntries->groupBy('qoe_id');

                foreach ($qoe_ids as $qoe_id) {
                    foreach ($grouped->get($qoe_id, collect()) as $entry) {
                        QOPFrequencyModel::create([
                            'qop_entry_id' => $createdId,
                            'office_entry_id' => $createdOffice,
                            'qop_id' => $qop_id,
                            'qoe_id' => $qoe_id,
                            'indicator' => $entry->indicator,
                            'rate' => $entry->rate,
                            'updated_by' => null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        } else {
            // No existing records, create 5 blank indicator records per qoe_id
            foreach ($qoe_ids as $qoe_id) {
                for ($i = 1; $i <= 5; $i++) {
                    QOPFrequencyModel::create([
                        'qop_entry_id' => $createdId,
                        'office_entry_id' => $createdOffice,
                        'qop_id' => $qop_id,
                        'qoe_id' => $qoe_id,
                        'indicator' => $i,
                        'rate' => json_encode($period),
                        'updated_by' => null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        return response()->json($postRS);
    }

    public function fetchQopHistoryData($id)
    {
        $FetchQoprHistory = QMSHistoryModel::select(
            'tbl_qms_sub_history.id',
            'tbl_qms_sub_history.qop_entry_id',
            'tbl_qms_sub_history.date_created',
            'tbl_qms_sub_history.created_by',
            'tbl_qms_sub_history.status',
            'tbl_qms_sub_history.remarks',
            'p.pmo_title',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname"),
            DB::raw("DATE_FORMAT(tbl_qms_sub_history.created_at, '%M %d, %Y %h:%i %p') as formatted_date")

        )
            ->leftjoin('users', 'users.id', '=', 'tbl_qms_sub_history.created_by')
            ->leftjoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->where('tbl_qms_sub_history.qop_entry_id', $id)
            ->get();

        return response()->json($FetchQoprHistory);
    }

    public function fetchQoprData($id)
    {
        $FetchQopr = QOPRModel::select(
            'tbl_qop_report.id',
            'users.pmo_id',
            'tbl_qop_report.qop_id',
            'tbl_qop_report.date_created',
            'tbl_qop_report.created_by',
            'tbl_qop_report.submitted_office',
            'tbl_qop_report.status',
            'tbl_qop_report.qp_covered',
            'qcoverage.coverage as coverage_name',
            'qop.qp_code',
            'qop.coverage',
            'qop.office',
            'qop.process_owner',
            'qop.frequency_monitoring',
            'qop.procedure_title',
            'qoe.objective',
            'qoe.target_percentage',
            'qoe.indicator_a',
            'qoe.indicator_b',
            'qoe.indicator_c',
            'qoe.indicator_d',
            'qoe.indicator_e',
            'qoe.formula',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fname")
        )
            ->leftJoin('tbl_qoe as qoe', 'qoe.qop_id', '=', 'tbl_qop_report.qop_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
            ->leftJoin('tbl_qop as qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'qop.coverage')
            ->where('tbl_qop_report.id', $id)
            ->get();


        return response()->json($FetchQopr);
    }
    public function fetchQoprEntryData($id)
    {
        $FetchQoprData = QOPRModel::select(
            'qoe.id as qoe_id',
            'tbl_qop_report.id',
            'tbl_qop_report.qop_id',
            'tbl_qop_report.date_created',
            'tbl_qop_report.created_by',
            'tbl_qop_report.status',
            'tbl_qop_report.qp_covered',
            'qoe.objective',
            'qoe.target_percentage',
            'qoe.formula',
            'qoe.indicator_a',
            'qoe.indicator_b',
            'qoe.indicator_c',
            'qoe.indicator_d',
            'qoe.indicator_e'
        )
            ->leftJoin('tbl_qoe AS qoe', 'qoe.qop_id', '=', 'tbl_qop_report.qop_id')
            ->where('tbl_qop_report.id', $id)
            ->get();
        return response()->json($FetchQoprData);
    }

    public function fetchQOPR()
    {

        $fetchQOPR = QOPRModel::select(
            'tbl_qop_report.id',
            'tbl_qop_report.qop_id',
            'tbl_qop_report.created_by',
            'users.username as uname',
            'tbl_qop_report.date_created',
            'tbl_qop_report.status',
            'tbl_qop_report.qp_covered',
            'tbl_qop_report.year',
            'qop.qp_code',
            'qop.frequency_monitoring',
            'qop.procedure_title',
            'qop.process_owner',
            'qop.office',
            'users.username',
        )

            ->leftJoin('tbl_qop as qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
            ->orderBy('tbl_qop_report.id', 'desc') // Added ordering here
            ->get();

        return response()->json($fetchQOPR);
    }

    public function fetchQOPR_processOwner_province()
    {
        $fetchQOPR = QOPRModel::select(
            'tbl_qop_report.id',
            'tbl_qop_report.qop_id',
            'tbl_qop_report.created_by',
            'users.pmo_id',
            'p.pmo_title',
            'tbl_qop_report.submitted_office',
            'users.username as uname',
            'tbl_qop_report.date_created',
            'tbl_qop_report.status',
            'tbl_qop_report.qp_covered',
            'tbl_qop_report.year',
            'qop.office',
            'qop.qp_code',
            'qop.frequency_monitoring',
            'qop.procedure_title',
            'qop.process_owner',
            'qcoverage.coverage'
        )
            ->leftJoin('tbl_qop as qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'qop.coverage')
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            // ->where('p.pmo_title', $userOffice1)
            ->orderBy('tbl_qop_report.id', 'desc');

        $result = $fetchQOPR->get();


        return response()->json($result);
    }
    public function fetchQOPRperProvince($id)
    {
        $fetchUser = UserModel::select(
            'users.username as username',
            'users.pmo_id',
            'p.pmo_title',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")

        )
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->where('users.id', $id)
            ->get();
        // $username = $fetchUser[0]->username;
        $userOffice1 = $fetchUser[0]->pmo_title;
        $userId = $fetchUser[0]->pmo_id;
        $userFName = $fetchUser[0]->fname;

        $fetchProcessOwner = QPModel::select('id', 'process_owner')
            ->whereRaw('FIND_IN_SET(?, REPLACE(process_owner, " ", ""))', [str_replace(' ', '', $userFName)])
            ->get();

        $matchedUser = null;

        if ($fetchProcessOwner->isEmpty()) {

            //For Provincial Process Owner
            $fetchQOPR = QOPRModel::select(
                'tbl_qop_report.id',
                'tbl_qop_report.qop_id',
                'tbl_qop_report.created_by',
                'users.pmo_id',
                'p.pmo_title',
                'tbl_qop_report.submitted_office',
                'users.username as uname',
                'tbl_qop_report.date_created',
                'tbl_qop_report.status',
                'tbl_qop_report.qp_covered',
                'tbl_qop_report.year',
                'qop.office',
                'qop.qp_code',
                'qop.frequency_monitoring',
                'qop.procedure_title',
                'qop.process_owner',
                'qcoverage.coverage'
            )
                ->leftJoin('tbl_qop as qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
                ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
                ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'qop.coverage')
                ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
                ->where('p.pmo_title', $userOffice1)
                ->orderBy('tbl_qop_report.id', 'desc')
                ->get();
            // return response()->json($fetchQOPR);
        } else {
            // For Regional Process Owner

            $processOwnersRaw = $fetchProcessOwner[0]->process_owner ?? '';


            // Split the names and trim spaces
            $processOwnerNames = array_map('trim', explode(',', $processOwnersRaw));

            foreach ($processOwnerNames as $fullName) {
                $strippedName = str_replace(' ', '', $fullName);

                $user = UserModel::select('id', 'first_name', 'last_name')
                    ->whereRaw('REPLACE(CONCAT(first_name, last_name), " ", "") = ?', [$strippedName])
                    ->first();

                if ($user) {
                    $matchedUser[] = $user;
                    // break; // or collect all if you want multiple matches
                }
            }

            $provinceList = ['CAVITE', 'LAGUNA', 'BATANGAS', 'RIZAL', 'QUEZON', 'LUCENA CITY'];
            $processIds = $fetchProcessOwner->pluck('id');

            $fetchQOPR = QOPRModel::select(
                'tbl_qop_report.id',
                'tbl_qop_report.qop_id',
                'tbl_qop_report.created_by',
                'users.pmo_id',
                'p.pmo_title',
                'tbl_qop_report.submitted_office',
                'users.username as uname',
                'tbl_qop_report.date_created',
                'tbl_qop_report.status',
                'tbl_qop_report.qp_covered',
                'tbl_qop_report.year',
                'qop.office',
                'qop.qp_code',
                'qop.frequency_monitoring',
                'qop.procedure_title',
                'qop.process_owner',
                'qcoverage.coverage'
            )
                ->leftJoin('tbl_qop as qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
                ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
                ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'qop.coverage')
                ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
                ->whereIn('p.pmo_title', $provinceList)
                ->whereIn('tbl_qop_report.qop_id', $processIds)
                ->orderBy('tbl_qop_report.id', 'desc')
                ->get();
        }
        return response()->json([
            'matched_users' => $matchedUser,
            'qop_reports' => $fetchQOPR,
        ]);
    }
    public function fetchQOPRperDivision($id)
    {
        $fetchUser = UserModel::select(
            'users.username as username',
            'users.pmo_id',
            'p.pmo_title',
            DB::raw("CONCAT(users.first_name, ' ',users.last_name) AS fname")

        )
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id')
            ->where('users.id', $id)
            ->get();
        // $username = $fetchUser[0]->username;
        $userOffice1 = $fetchUser[0]->pmo_title;
        $userId = $fetchUser[0]->pmo_id;

        $commonPMOTitles = [
            'ORD',
            'ORD-LEGAL',
            'ORD-PLANNING',
            'ORD-RICTU',
            'ORD-Legal',
            'ORD-Planning',
            'LGMED',
            'LGMED-MBRTG',
            'FAD'
        ];

        $fetchQOPR = QOPRModel::select(
            'tbl_qop_report.id',
            'tbl_qop_report.qop_id',
            'tbl_qop_report.created_by',
            'users.pmo_id',
            'p.pmo_title',
            'tbl_qop_report.submitted_office',
            'users.username as uname',
            'tbl_qop_report.date_created',
            'tbl_qop_report.status',
            'tbl_qop_report.qp_covered',
            'tbl_qop_report.year',
            'qop.office',
            'qop.qp_code',
            'qop.frequency_monitoring',
            'qop.procedure_title',
            'qop.process_owner',
            'qcoverage.coverage'
        )
            ->leftJoin('tbl_qop as qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
            ->leftJoin('tbl_qop_coverage as qcoverage', 'qcoverage.id', '=', 'qop.coverage')
            ->leftJoin('pmo as p', 'p.id', '=', 'users.pmo_id');

        // Grouped regional logic
        $regionalOffices = [
            'ORD' => '%ORD%',
            'ORD-LEGAL' => '%ORD%',
            'ORD-PLANNING' => '%ORD%',
            'ORD-RICTU' => '%ORD%',
            'ORD-Legal' => '%ORD%',
            'ORD-Planning' => '%ORD%',
            'LGMED' => '%LGMED%',
            'LGMED-MBRTG' => '%LGMED%',
            'LGCDD' => '%LGCDD%',
            'LGCDD-PDMU' => '%LGCDD%',
            'FAD' => '%FAD%',
        ];

        if (array_key_exists($userOffice1, $regionalOffices)) {
            $fetchQOPR->where('qop.office', 'LIKE', $regionalOffices[$userOffice1])
                ->whereIn('p.pmo_title', $commonPMOTitles);
        } elseif (in_array($userOffice1, ['CAVITE', 'LAGUNA', 'BATANGAS', 'RIZAL', 'QUEZON', 'LUCENA CITY'])) {
            $fetchQOPR->where('qcoverage.coverage', 'LIKE', '%Province%')
                ->where('users.pmo_id', $userId);
        }

        $fetchQOPR->orderBy('tbl_qop_report.id', 'desc');

        $result = $fetchQOPR->get();

        return response()->json($result);

        //add subheader for provincial submission for cleaner approach and preventing code duplication and rendering issues
    }

    public function fetchQOPRUserData($id, $qoe_id)
    {
        $fetchData = QOPModel::select(
            'tbl_qoe.id',
            'tbl_qoe.qop_id',
            'tbl_qoe.objective',
            'tbl_qoe.target_percentage',
            'tbl_qoe.indicator_a',
            'tbl_qoe.indicator_b',
            'tbl_qoe.indicator_c',
            'tbl_qoe.indicator_d',
            'tbl_qoe.indicator_e',
            'tbl_qoe.formula',
            'gap.id as gap_id',
            'gap.is_gap_analysis',
            'gap.gap_analysis',
            'gap.qoe_id as gap_qoe_id'
        )
            ->leftJoin('tbl_qms_gap_analysis as gap', function ($join) use ($id) {
                $join->on('gap.qoe_id', '=', 'tbl_qoe.id')
                    ->where('gap.qop_entry_id', '=', $id);
            })
            ->where('tbl_qoe.id', $qoe_id)
            ->get();

        return response()->json($fetchData);
    }
    public function completeReport(request $request)
    {
        QOPRModel::where('id', $request->id)->update(['status' => '4']);

        $subHistory = new QMSHistoryModel([
            'qop_entry_id' => $request->id,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => $request->userId,
            'status' => '4',
            'remarks' => $request->remarks,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $subHistory->save();
    }
    public function returnReport(request $request)
    {
        QOPRModel::where('id', $request->id)->update(['status' => '3']);

        $subHistory = new QMSHistoryModel([
            'qop_entry_id' => $request->id,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => $request->userId,
            'status' => '3',
            'remarks' => $request->remarks,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $subHistory->save();
    }

    public function receiveReport(request $request)
    {
        QOPRModel::where('id', $request->id)->update(['status' => '2']);

        $subHistory = new QMSHistoryModel([
            'qop_entry_id' => $request->id,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => $request->userId,
            'status' => '2',
            'remarks' => $request->remarks,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $subHistory->save();
    }
    public function submitReport(request $request)
    {
        QOPRModel::where('id', $request->id)->update(['status' => '1']);

        $subHistory = new QMSHistoryModel([
            'qop_entry_id' => $request->id,
            'date_created' => Carbon::now('Asia/Manila')->format('Y-m-d H:i:s'),
            'created_by' => $request->userId,
            'status' => '1',
            'remarks' => $request->remarks,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $subHistory->save();

        // return response()->json($subHistory);

        // $SubmitReport = new QOPRModel([
        //     'status' => '1',
        // ])
        // ->where('id', $request->id);
        // $SubmitReport->save();
    }

    public function deleteRS(request $request)
    {
        QOPRModel::where('id', $request->id)

            ->delete();

        QOPFrequencyModel::where('qop_entry_id', $request->id)
            ->delete();

        QGAModel::where('qop_entry_id', $request->id)
            ->delete();

        QMSHistoryModel::where('qop_entry_id', $request->id)
            ->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}
