<?php


namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\UserModel;
use App\Models\RICTUModel;
use Illuminate\Http\Request;
use Cossou\PhpJasper\PhpJasper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class RICTUController extends Controller
{
    const STATUS_DRAFT      = 1;
    const STATUS_RECEIVED   = 2;
    const STATUS_COMPLETED  = 3;
    const STATUS_RETURNED   = 4;
    const STATUS_RATED      = 5;

    public function ict_data()
    {
        return response()->json(RICTUModel::select('')
            ->limit(1000)
            ->get());
    }
    public function generateICTControlNo()
    {
        $currentYear = date('Y');
        return response()->json(
            RICTUModel::select(RICTUModel::raw('COUNT(*)+1 as "ict_no_count"'))
                ->whereYear('request_date', $currentYear)
                ->get()
        );
    }

    public function getUserData()
    {
        // Get the currently logged-in user's data
        $user = auth()->user();

        if ($user) {
            // Return the user's data as a JSON response
            return response()->json([
                'user_role' => $user->user_role,
            ]);
        } else {
            // Return an error response if the user is not logged in
            return response()->json(['error' => 'You are not logged in'], 401);
        }
    }

    public function getICTpersonnel()
    {
        $ict_personnel = DB::table('tbl_ict_personnel')
            ->select('emp_id', 'ict_personnel')
            ->get();
        return response()->json($ict_personnel);
    }

    public function getICTData($id)
    {
        $query = RICTUModel::select(RICTUModel::raw('
            tbl_technicalassistance.id AS id,
            tbl_technicalassistance.request_type_id AS req_id,
            tbl_technicalassistance.request_type_category_id AS req_cat_id,
            tbl_technicalassistance.others AS others,
            tbl_technicalassistance.portal_system AS portal_system,
            tbl_technicalassistance.others_software AS others_software,
            tbl_technicalassistance.website_access AS website_access,
            tbl_technicalassistance.control_no AS control_no,
            CONCAT(u.first_name," ",u.last_name) AS requested_by,
            u.user_role as role,
            u.email,
            u.contact_details as contact,
            tbl_technicalassistance.started_date AS requested_date,
            TIME(tbl_technicalassistance.started_date) AS started_time,
            MONTH(tbl_technicalassistance.started_date) AS month,
            YEAR(tbl_technicalassistance.started_date) AS YEAR,
            tbl_technicalassistance.started_date AS started_date,
            tbl_technicalassistance.completed_date AS completed_date,
            tbl_technicalassistance.remarks AS remarks,
             tbl_technicalassistance.ict_officer_remarks AS ict_officer_remarks,
            cl.link AS css_link,
            p.pmo_title AS office,
            itr.request_type AS request_type,
            c.TITLE AS sub_request_type,
            ip.ict_personnel AS ict_personnel,
            is.status AS status,
            is.id AS status_id
        '))
            ->leftJoin('tbl_ict_personnel as ip', 'ip.emp_id', '=', 'tbl_technicalassistance.assign_ict_officer')
            ->leftJoin('users as u', 'u.id', '=', 'tbl_technicalassistance.request_by')
            ->leftJoin('pmo as p', 'p.id', '=', 'tbl_technicalassistance.office_id')
            ->leftJoin('tbl_ict_type_of_request as itr', 'itr.id', '=', 'tbl_technicalassistance.request_type_id')
            ->leftJoin('tbl_ict_request_category as c', 'c.id', '=', 'tbl_technicalassistance.request_type_category_id')
            ->leftJoin('tbl_ict_status as is', 'is.id', '=', 'tbl_technicalassistance.status_id')
            ->leftJoin('tbl_css_link as cl', 'cl.id', '=', 'tbl_technicalassistance.css_link')
            ->where('tbl_technicalassistance.id', $id)
            ->orderBy('id', 'DESC');
        $data = $query->first(); // Use first() instead of get() to retrieve a single result
        return response()->json($data);
    }


    public function fetch_ict_request(Request $request, $status = null)
    {
        $page = $request->query('page', 1);
        $itemsPerPage = $request->query('itemsPerPage', 10000);
        $control_no = $request->query('control_no');
        $requested_by = $request->query('requested_by');
        $ict_personnel = $request->query('ict_personnel');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $pmo = $request->query('pmo');
        $year = $request->query('year', date('Y'));
        $quarter = $request->query('quarter');

        $ictQuery = DB::table('tbl_technicalassistance')
            ->select(DB::raw('
                tbl_technicalassistance.id AS id,
                tbl_technicalassistance.control_no,
                CONCAT(u.first_name, " ", u.last_name) AS requested_by,
                u.user_role AS role,
                tbl_technicalassistance.started_date,
                TIME(tbl_technicalassistance.started_date) AS started_time,
                MONTH(tbl_technicalassistance.started_date) AS month,
                YEAR(tbl_technicalassistance.started_date) AS year,
                tbl_technicalassistance.request_date,
                tbl_technicalassistance.completed_date,
                tbl_technicalassistance.remarks,
                cl.link AS css_link,
                p.pmo_title AS office,
                itr.request_type,
                c.TITLE AS sub_request_type,
                ip.ict_personnel,
                ip.emp_id AS ict_personnel_id,
                is.status,
                is.id AS status_id
            '))
            ->leftJoin('users as u', 'u.id', '=', 'tbl_technicalassistance.request_by')
            ->leftJoin('tbl_ict_personnel as ip', 'ip.emp_id', '=', 'tbl_technicalassistance.assign_ict_officer')
            ->leftJoin('pmo as p', 'p.id', '=', 'tbl_technicalassistance.office_id')
            ->leftJoin('tbl_ict_type_of_request as itr', 'itr.id', '=', 'tbl_technicalassistance.request_type_id')
            ->leftJoin('tbl_ict_request_category as c', 'c.id', '=', 'tbl_technicalassistance.request_type_category_id')
            ->leftJoin('tbl_ict_status as is', 'is.id', '=', 'tbl_technicalassistance.status_id')
            ->leftJoin('tbl_css_link as cl', 'cl.id', '=', 'tbl_technicalassistance.css_link')
            ->whereYear('tbl_technicalassistance.created_at', $year)
            ->when($status !== null && $status != 6, fn($q) => $q->where('tbl_technicalassistance.status_id', $status))
            ->when($control_no, fn($q) => $q->where('tbl_technicalassistance.control_no', 'LIKE', "%$control_no%"))
            ->when($requested_by, fn($q) =>
                $q->where(DB::raw('CONCAT(u.first_name, " ", u.last_name)'), 'LIKE', "%$requested_by%")
            )
            ->when($ict_personnel, fn($q) =>
                $q->where(DB::raw('ip.ict_personnel'), 'LIKE', "%$ict_personnel%")
            )
            ->when($start_date && $end_date, fn($q) =>
                $q->whereBetween('tbl_technicalassistance.started_date', [
                    $start_date,
                    date('Y-m-d 23:59:59', strtotime($end_date))
                ])
            )
            ->when($pmo, fn($q) =>
                $q->where(DB::raw('p.pmo_title'), 'LIKE', "%$pmo%")
            )
            ->when($quarter, fn($q) =>
                $q->whereBetween('tbl_technicalassistance.started_date', $this->getQuarterDateRange($quarter, $year))
            )
            ->orderByDesc('tbl_technicalassistance.control_no');

        $ict = ($itemsPerPage == -1)
            ? $ictQuery->get()
            : $ictQuery->paginate($itemsPerPage, ['*'], 'page', $page);

        return response()->json($ict);
    }

    /**
     * Return date range array for a given quarter and year
     */
    private function getQuarterDateRange($quarter, $year)
    {
        $ranges = [
            1 => ["$year-01-01", "$year-03-31 23:59:59"],
            2 => ["$year-04-01", "$year-06-30 23:59:59"],
            3 => ["$year-07-01", "$year-09-30 23:59:59"],
            4 => ["$year-10-01", "$year-12-31 23:59:59"],
        ];

        return $ranges[$quarter] ?? ["$year-01-01", "$year-12-31 23:59:59"];
    }

    public function fetch_ict_perUser(Request $request, $status, $userID)
    {
        $page = $request->query('page');
        $itemsPerPage = $request->query('itemsPerPage', 10000);
        $year = $request->query('year', date('Y')); // Default to the current year

        $ictQuery = RICTUModel::select(RICTUModel::raw('
            tbl_technicalassistance.id AS id,
            tbl_technicalassistance.control_no AS control_no,
            CONCAT(u.first_name," ",u.last_name) AS requested_by,
            u.user_role as role,
            tbl_technicalassistance.started_date AS started_date,
            TIME(tbl_technicalassistance.started_date) AS started_time,
            MONTH(tbl_technicalassistance.started_date) AS month,
            YEAR(tbl_technicalassistance.started_date) AS YEAR,
            tbl_technicalassistance.request_date AS request_date,
            tbl_technicalassistance.completed_date AS completed_date,
            tbl_technicalassistance.remarks AS remarks,
            cl.link AS css_link,
            p.pmo_title AS office,
            itr.request_type AS request_type,
            c.TITLE AS sub_request_type,
            ip.ict_personnel AS ict_personnel,
            is.status AS status,
            is.id AS status_id
        '))
            ->leftJoin('tbl_ict_personnel as ip', 'ip.emp_id', '=', 'tbl_technicalassistance.assign_ict_officer')
            ->leftJoin('users as u', 'u.id', '=', 'tbl_technicalassistance.request_by')
            ->leftJoin('pmo as p', 'p.id', '=', 'tbl_technicalassistance.office_id')
            ->leftJoin('tbl_ict_type_of_request as itr', 'itr.id', '=', 'tbl_technicalassistance.request_type_id')
            ->leftJoin('tbl_ict_request_category as c', 'c.id', '=', 'tbl_technicalassistance.request_type_category_id')
            ->leftJoin('tbl_ict_status as is', 'is.id', '=', 'tbl_technicalassistance.status_id')
            ->leftJoin('tbl_css_link as cl', 'cl.id', '=', 'tbl_technicalassistance.css_link')
            ->whereYear('tbl_technicalassistance.created_at', $year);

        if ($status == 6) {
            $ictQuery->where('tbl_technicalassistance.request_by', $userID);
        } else {
            $ictQuery->where('tbl_technicalassistance.status_id', $status);
        }

        $ictQuery->orderBy('control_no', 'DESC');

        $ict = $ictQuery->paginate($itemsPerPage, ['*'], 'page', $page);

        return response()->json($ict);
    }


    public function post_create_ict_request(Request $request)
    {
        // dd($request->all());
        $portal_system = $request->input('portal_sys') ?? null;
        $website_access = $request->input('web_access') ?? null;

        $requestedDate = $request->input('requested_date');
        $month = Carbon::parse($requestedDate)->format('m');
        $req = $request->input('type_of_request');

        $userId = $request->input('requested_by');
        $user = UserModel::selectRaw('
            users.id as id,
            CONCAT(users.first_name, " ", users.middle_name, " ", users.last_name) as name,
            users.username
        ')
            ->where('users.id', $userId)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User  not found'], 404);
        }

        // ✅ Define and process `$assignedOfficer` properly
        $assignedOfficer = $request->input('assign_ict_officer', null); // Get the input value, default to null
        // dd($assignedOfficer);
        if (is_array($assignedOfficer)) { // If it's an array, convert to a string
            $assignedOfficer = implode(',', $assignedOfficer);
        }

        DB::beginTransaction();

        try {
            // Create the ICT request
            $ict_opts = new RICTUModel([
                'control_no' => $request->input('control_no'),
                'request_by' => $userId,
                'request_date' => $requestedDate,
                'received_date' => $assignedOfficer  ? $requestedDate : null,
                'started_date' => $assignedOfficer ? $requestedDate : null,
                'office_id' => $request->input('pmo'),
                'unit_id' => $request->input('email'),
                'equipment_type' => $request->input('equipment_type'),
                'brand' => $request->input('brand'),
                'property_no' => $request->input('property_no'),
                'serial_no' => $request->input('equipment_sn'),
                'others' => $req == 9 ? $request->input('subRequest') : null,
                'portal_system' => $portal_system,
                'website_access' => $website_access,
                'request_type_category_id' => $req == 9 ? 37 : $request->input('subRequest'),
                'request_type_id' => $req,
                'assign_ict_officer' => $assignedOfficer,
                'status_id' => $assignedOfficer ? self::STATUS_RECEIVED : self::STATUS_DRAFT,
                'remarks' => $request->input('remarks'),
                'css_link' => $month
            ]);

            $ict_opts->save();

            // Send notification via Pusher
            $options = [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            // Prepare the data for the notification
            $data = [
                'id' => $ict_opts->id, // Unique ID of the request
                'username' => $user->username, // Username of the requester
                'name' => $user->name, // Full name of the requester
                'requester_id' => $userId, // Requester ID
            ];

            // Trigger the event for admins
            $pusher->trigger('ict-ta-channel', 'new-ict-ta', $data);

            DB::commit();

            // Return a success response
            return response()->json(['message' => 'ICT request created successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Return an error response
            return response()->json(['error' => 'Failed to create ICT request.'], 500);
        }
    }





    public function fetch_ict_req_details(Request $request)
    {
        $id = $request->input('control_id');

        $ict_ta_opts = RICTUModel::select([
            'tbl_technicalassistance.id',
            'tbl_technicalassistance.control_no',
            DB::raw('CONCAT(u.first_name, " ", u.last_name) AS requested_by'),
            'tbl_technicalassistance.request_date',
            'tbl_technicalassistance.received_date',
            'tbl_technicalassistance.remarks',
            'pmo.pmo_title as office',
            'itr.request_type as request_type',
            'c.TITLE as sub_request_type',
            'ip.ict_personnel as ict_personnel',
            'is.status'
        ])
            ->leftJoin('tbl_ict_personnel as ip', 'ip.emp_id', '=', 'tbl_technicalassistance.assign_ict_officer')
            ->leftJoin('users as u', 'u.id', '=', 'tbl_technicalassistance.request_by')
            ->leftJoin('pmo', 'pmo.id', '=', 'tbl_technicalassistance.office_id')
            ->leftJoin('tbl_ict_type_of_request as itr', 'itr.id', '=', 'tbl_technicalassistance.request_type_id')
            ->leftJoin('tbl_ict_request_category as c', 'c.REQUEST_ID', '=', 'itr.id')
            ->leftJoin('tbl_ict_status as is', 'is.id', '=', 'tbl_technicalassistance.status_id')
            ->where('tbl_technicalassistance.id', $id)
            ->first();

        if ($ict_ta_opts && $ict_ta_opts->id) {
            return response()->json([
                'id' => $ict_ta_opts->id,
                'control_no' => $ict_ta_opts->control_no ?? 'N/A',
                'requested_by' => $ict_ta_opts->requested_by ?? 'Unknown',
                'request_date' => $ict_ta_opts->request_date,
                'received_date' => $ict_ta_opts->received_date,
                'remarks' => $ict_ta_opts->remarks,
                'office' => $ict_ta_opts->office ?? 'Unknown',
                'request_type' => $ict_ta_opts->request_type ?? 'Unknown',
                'sub_request_type' => $ict_ta_opts->sub_request_type ?? 'Unknown',
                'ict_personnel' => $ict_ta_opts->ict_personnel ?? 'Unassigned',
                'status' => $ict_ta_opts->status ?? 'Unknown'
            ]);
        } else {
            return response()->json(['error' => 'Request not found'], 404);
        }
    }
    public function countICTRequest($userId)
    {
        $cur_year = date('Y');
        $requestCount = RICTUModel::where('request_by', $userId)
            ->whereYear('created_at', $cur_year)
            ->count();

        return response()->json(['ict' => $requestCount]);
    }

    public function countDRAFT($userId)
    {
        $userYear = date('Y');
        return response()->json(
            RICTUModel::select(
                RICTUModel::raw('COUNT(CASE WHEN status_id = 1 THEN 1 END) as draft'),
                RICTUModel::raw('COUNT(CASE WHEN status_id = 2 THEN 1 END) as received'),
                RICTUModel::raw('COUNT(CASE WHEN status_id = 3 THEN 1 END) as completed'),
                RICTUModel::raw('COUNT(CASE WHEN status_id = 4 THEN 1 END) as returned')
            )
                ->whereYear('created_at', $userYear)
                ->where('request_by', $userId)
                ->get()
        );
    }

    public function totalCountICTrequest()
    {
        $currentYear = date('Y');
        $count = RICTUModel::select(RICTUModel::raw('count(*) as ictTotal'))
            ->whereYear('created_at', $currentYear)
            ->first();

        return response()->json(['ictTotal' => $count->ictTotal]);
    }

    public function totalCountDraft()
    {
        $currentYear = date('Y');
        return response()->json(
            RICTUModel::select(
                RICTUModel::raw('COUNT(CASE WHEN status_id = 1 THEN 1 END) as draft'),
                RICTUModel::raw('COUNT(CASE WHEN status_id = 2 THEN 1 END) as received'),
                RICTUModel::raw('COUNT(CASE WHEN status_id = 3 THEN 1 END) as completed'),
                RICTUModel::raw('COUNT(CASE WHEN status_id = 4 THEN 1 END) as returned')
            )
                ->whereYear('created_at', $currentYear)
                ->get()
        );
    }


    public function generate($selectedYear, $selectedQuarter, $requestType)
    {
        $monthRange = '';
        $quarter = '';
        $rt = ($requestType == 1) ? 'PML' : 'ICT-TA-Monitoring-Log-Sheet';

        switch ($selectedQuarter) {
            case '1':
                $monthRange = '(1,2,3)';
                $quarter = '1st Quarter';
                break;
            case '2':
                $monthRange = '(4,5,6)';
                $quarter = '2nd Quarter';
                break;
            case '3':
                $monthRange = '(7,8,9)';
                $quarter = '3rd Quarter';
                break;
            case '4':
                $monthRange = '(10,11,12)';
                $quarter = '4th Quarter';
                break;
            default:
                return response()->json([
                    'error' => 'Invalid quarter selected'
                ], 400);
        }

        $templatePath = public_path('templates/rictu_report_template.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Set title and headers on the first sheet
        $sheet->setCellValue('C7', $quarter);
        $sheet->setCellValue('E7', $selectedYear);

        $query = RICTUModel::select(RICTUModel::raw('
        tbl_technicalassistance.id as id,
        tbl_technicalassistance.control_no as control_no,
        CONCAT(u.first_name, " ", u.last_name) AS requested_by,
        TIME(tbl_technicalassistance.started_date) as started_time,
        TIME(tbl_technicalassistance.completed_date) as completed_time,
        tbl_technicalassistance.request_date as request_date,
        tbl_technicalassistance.started_date as started_date,
        tbl_technicalassistance.completed_date as completed_date,
        tbl_technicalassistance.remarks as remarks,
        p.pmo_title as office,
        ip.ict_personnel as ict_personnel,
        itr.request_type as request_type
    '))
            ->leftJoin('tbl_ict_personnel as ip', 'ip.emp_id', '=', 'tbl_technicalassistance.assign_ict_officer')
            ->leftJoin('users as u', 'u.id', '=', 'tbl_technicalassistance.request_by')
            ->leftJoin('pmo as p', 'p.id', '=', 'tbl_technicalassistance.office_id')
            ->leftJoin('tbl_ict_type_of_request as itr', 'itr.id', '=', 'tbl_technicalassistance.request_type_id')
            ->whereYear('tbl_technicalassistance.request_date', '=', $selectedYear)
            ->whereRaw('MONTH(tbl_technicalassistance.request_date) IN ' . $monthRange)
            ->get();

        $row = 10;

        // Define the style array for borders
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $dateFormat = 'mm/dd/yyyy';
        foreach ($query as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $data['control_no']);
            $sheet->setCellValue('C' . $row, Date::PHPToExcel($data['started_date']));
            $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode($dateFormat);
            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('hh:mm AM/PM');
            $sheet->setCellValue('D' . $row, $data['started_time']);
            $sheet->setCellValue('E' . $row, $data['requested_by']);
            $sheet->setCellValue('F' . $row, $data['office']);
            $sheet->setCellValue('G' . $row, $data['remarks']);
            $sheet->setCellValue('H' . $row, $data['ict_personnel']);
            $sheet->setCellValue('K' . $row, Date::PHPToExcel($data['completed_date']));
            $sheet->getStyle('K' . $row)->getNumberFormat()->setFormatCode($dateFormat);
            $sheet->getStyle('L' . $row)->getNumberFormat()->setFormatCode('hh:mm AM/PM');
            $sheet->setCellValue('L' . $row, $data['completed_time']);
            $sheet->setCellValue('M' . $row, '=IF((K' . $row . '-C' . $row . ')>=1/24,HOUR(K' . $row . '-C' . $row . ') & IF(HOUR(K' . $row . '-C' . $row . ') = 1, " Hour and ", " Hours and ") & (MINUTE(K' . $row . '-C' . $row . ') + IF(SECOND(K' . $row . '-C' . $row . ') > 0, 1, 0)) & " Minutes", (INT((K' . $row . '-C' . $row . ')*1440) + IF(SECOND(K' . $row . '-C' . $row . ') > 0, 1, 0)) & " Minutes")');

            $sheet->getRowDimension($row)->setRowHeight(60);

            try {
                // Apply the border style to the current row
                $sheet->getStyle("A{$row}:M{$row}")->applyFromArray($styleArray);
                // Apply green background color to Cell K
                $sheet->getStyle("K{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Error applying styles: ' . $e->getMessage()
                ], 500);
            }

            $row++;
        }

        // Calculate the row for the signatories
        $signatoryRow = $row + 3; // leave one row of space after the data

        // Define the signatory style array
        $signatoryStyleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        // Set "Prepared By" section
        $sheet->mergeCells('E' . $signatoryRow . ':F' . $signatoryRow);
        $sheet->setCellValue('E' . $signatoryRow, 'PREPARED BY:');
        $sheet->mergeCells('E' . ($signatoryRow + 1) . ':F' . ($signatoryRow + 2));
        $sheet->setCellValue('E' . ($signatoryRow + 1), 'MAYBELLINE M. MONTEIRO');
        $sheet->mergeCells('E' . ($signatoryRow + 3) . ':F' . ($signatoryRow + 4));
        $sheet->setCellValue('E' . ($signatoryRow + 3), 'Process Owner');

        // Apply style to "Prepared By" section
        $sheet->getStyle('E' . $signatoryRow . ':F' . ($signatoryRow))->applyFromArray($signatoryStyleArray);
        $sheet->getStyle('E' . $signatoryRow . ':F' . ($signatoryRow + 2))->applyFromArray($signatoryStyleArray);
        $sheet->getStyle('E' . $signatoryRow . ':F' . ($signatoryRow + 4))->applyFromArray($signatoryStyleArray);
        $sheet->getStyle('E' . ($signatoryRow + 1))->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle('E' . $signatoryRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Apply background color to "Prepared By" section
        $sheet->getStyle('E' . $signatoryRow . ':F' . $signatoryRow)
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('000000');

        // Apply font color to "Prepared By" section
        $sheet->getStyle('E' . $signatoryRow . ':F' . $signatoryRow)
            ->getFont()->getColor()->setARGB('FFFFFF');

        // Set "Noted By" section
        $sheet->mergeCells('H' . $signatoryRow . ':J' . $signatoryRow);
        $sheet->setCellValue('H' . $signatoryRow, 'NOTED BY:');
        $sheet->mergeCells('H' . ($signatoryRow + 1) . ':J' . ($signatoryRow + 2));
        $sheet->setCellValue('H' . ($signatoryRow + 1), 'DARRELL I. DIZON');
        $sheet->mergeCells('H' . ($signatoryRow + 3) . ':J' . ($signatoryRow + 4));
        $sheet->setCellValue('H' . ($signatoryRow + 3), 'Regional Quality Management Representative');

        // Apply style to "Noted By" section
        $sheet->getStyle('H' . $signatoryRow . ':J' . ($signatoryRow))->applyFromArray($signatoryStyleArray);
        $sheet->getStyle('H' . $signatoryRow . ':J' . ($signatoryRow + 2))->applyFromArray($signatoryStyleArray);
        $sheet->getStyle('H' . $signatoryRow . ':J' . ($signatoryRow + 4))->applyFromArray($signatoryStyleArray);
        $sheet->getStyle('H' . ($signatoryRow + 1))->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle('H' . $signatoryRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Apply background color to "Noted By" section
        $sheet->getStyle('H' . $signatoryRow . ':J' . $signatoryRow)
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('000000');

        // Apply font color to "Noted By" section
        $sheet->getStyle('H' . $signatoryRow . ':J' . $signatoryRow)
            ->getFont()->getColor()->setARGB('FFFFFF');


        $writer = new Xlsx($spreadsheet);
        $fileName = $rt . '-' . $quarter . '-' . $selectedYear . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
