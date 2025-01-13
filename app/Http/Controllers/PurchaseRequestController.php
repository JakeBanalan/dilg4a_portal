<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AppItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PurchaseRequestModel;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequestItemModel;

use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

const SUBMITTED_TO_BUDGET = 2;
const SUBMITTED_TO_GSS = 4;
const RECEIVED_BY_GSS = 5;
const RECEIVED_BY_BUDGET = 3;
const WITH_RFQ = 6;
const AWARDED = 7;
const WITH_PO = 8;
class PurchaseRequestController extends Controller
{


    public function generatePurchaseRequestNo($cur_year = null)
    {
        $cur_year = $cur_year ?? date('Y');

        return response()->json(
            PurchaseRequestModel::select(PurchaseRequestModel::raw('COUNT(*)+1 as "pr_count" '))
                ->whereYear('date_added', $cur_year)
                ->get()
        );
    }


    public function post_create_purchaseRequest(Request $request)
    {
        // Create a new instance of PurchaseRequestModel
        $purchaseRequest = new PurchaseRequestModel();

        // Set the purchase request fields
        $purchaseRequest->pr_no = $request->input('pr_no');
        $purchaseRequest->pmo = $request->input('pmo');
        $purchaseRequest->type = $request->input('type');
        $purchaseRequest->pr_date = $request->input('pr_date');
        $purchaseRequest->target_date = $request->input('target_date');
        $purchaseRequest->purpose = $request->input('purpose');
        $purchaseRequest->action_officer = $request->input('created_by');
        $purchaseRequest->is_urgent = $request->input('isUrgent');
        $purchaseRequest->stat = 1;

        // Save the purchase request
        $purchaseRequest->save();

        // Get the PR ID of the newly created purchase request
        $pr_id = $purchaseRequest->id;

        // Process the items array
        $items = $request->input('items');
        foreach ($items as $item) {
            // Check if the PR ID and item ID combination already exists
            $existingItem = PurchaseRequestItemModel::where('pr_id', $pr_id)
                ->where('pr_item_id', $item['id'])
                ->first();

            if ($existingItem) {
                // If the combination exists, update the quantity
                $existingItem->qty += $item['quantity'];
                $existingItem->abc = $existingItem->qty * $item['price'];
                $existingItem->save();
            } else {
                // If the combination doesn't exist, insert a new record
                $pr_opts = new PurchaseRequestItemModel([
                    'id'            => null,
                    'pr_id'         => $pr_id,
                    'pr_item_id'    => $item['id'],
                    'description'   => $item['description'],
                    'qty'           => $item['quantity'],
                    'abc'           => $item['quantity'] * $item['price'],
                    'date_added'    => now(), // Automatically set the date_added field to the current date and time
                    'flag'          => 1, // Set the flag field to a default value of 1
                ]);
                $pr_opts->save();
            }
        }

        // Update the current step of the purchase request
        $purchaseRequest->current_step = $request->input('step');
        $purchaseRequest->save();

        // Return a response indicating success
        return response()->json(['message' => 'Purchase request and items created successfully']);
    }

    public function post_update_purchaseRequestDetailsForm(Request $request)
    {
        // Assuming your model is named PurchaseRequestModel
        $purchaseRequest = PurchaseRequestModel::where('pr_no', $request->input('pr_no'))->first();

        // Update the record
        PurchaseRequestModel::where('id', $request->input('pr_id'))
            ->update([
                'pmo' => $request->input('pmo'),
                'type' => $request->input('type'),
                'pr_date' => $request->input('pr_date'),
                'target_date' => $request->input('target_date'),
                'purpose' => $request->input('purpose'),
                'current_step' => $request->input('step'),
            ]);


        // You can return a response, if needed
        return response()->json(['message' => 'Purchase request details updated successfully']);
    }


    public function fetchItems()
    {
        try {
            $items = AppItemModel::select('tbl_app.id', 'tbl_app.item_title as name', 'tbl_app.app_price as price', 'tbl_app.sn as stockno', 'unit.item_unit_title as unit')
                ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
                ->get();

            if ($items->isEmpty()) {
                return response()->json(['message' => 'No items found'], 404);
            }

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching items'], 500);
        }
    }

    public function fetchPurchaseReqData(Request $request)
    {
        $page = $request->query('page', 1); // Default to page 1 if not provided
        $itemsPerPage = $request->query('itemsPerPage', 100); // Consider a lower default

        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
            pr.id AS `id`,
            MAX(pr.pr_no) AS `pr_no`,
            MAX(pr.action_officer) AS `user_id`,
            CONCAT(MAX(users.first_name), " " , MAX(users.last_name)) AS `created_by`,
            MAX(pr.current_step) AS `step`,
            MAX(pmo.pmo_title) AS `office`,
            MAX(pr.submitted_by) AS `submitted_by`,
            MAX(pr.purpose) AS `particulars`,
            MAX(pr.pr_date) AS `pr_date`,
            MAX(pr.target_date) AS `target_date`,
            MAX(pr.is_urgent) AS `is_urgent`,
            MAX(pr_items.qty) AS `quantity`,
            MAX(pr_items.description) AS `desc`,
            MAX(mode.mode_of_proc_title) AS `type`,
            MAX(app.sn) AS `serial_no`,
            MAX(app.item_title) AS `item_title`,
            MAX(unit.item_unit_title) AS `unit`,
            MAX(status.title) AS `status`,
            MAX(status.id) AS `status_id`,
            SUM(pr_items.qty * app.app_price) AS `app_price`
        '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id') // Adjusted join
            ->leftJoin('tbl_status as status', 'status.id', '=', 'pr.stat')
            ->orderBy('pr.id', 'desc')
            ->groupBy('pr.id');

        try {
            $prData = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }

        return response()->json($prData);
    }


    public function viewPurchaseRequest($id)
    {
        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
            pr.id AS `id`,
            pr.type AS `type`,
            pr.pr_no AS `pr_no`,
            pr.action_officer AS `user_id`,
            users.last_name AS `created_by`,
            pmo.id AS `office`,
            pr.submitted_by AS `submitted_by`,
            pr.purpose AS `particulars`,
            pr.pr_date AS `pr_date`,
            pr.target_date AS `target_date`,
            pr.is_urgent AS `is_urgent`,
            pr_items.qty AS `quantity`,
            pr_items.description AS `desc`,
            app.sn AS `serial_no`,
            app.item_title AS `item_title`,
            unit.item_unit_title as  `unit`,
            app.app_price AS `price`
        '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id')
            ->where('pr.id', $id)
            ->first();

        $prItems = PurchaseRequestItemModel::where('pr_id', $id)
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id')
            ->select('pr_items.*', 'app.app_price AS price', 'app.sn as serial_no', 'app.item_title as item_title', 'unit.item_unit_title as unit')
            ->get();

        return response()->json([
            'purchaseRequest' => $query,
            'pr_items' => $prItems
        ]);
    }

    public function updatePurchaseRequestStatus(Request $request)
    {
        // Get the purchase request
        $purchaseRequest = PurchaseRequestModel::find($request->input('id'));

        if (!$purchaseRequest) {
            return response()->json(['message' => 'Purchase request not found'], 404);
        }

        // Update the status if provided
        if ($request->has('status')) {
            $purchaseRequest->stat = $request->input('status');
        }

        // Update submission flags if provided
        if ($request->has('is_budget_submitted')) {
            $purchaseRequest->is_budget_submitted = $request->input('is_budget_submitted');
            if ($purchaseRequest->is_budget_submitted) {
                $purchaseRequest->submitted_date = Carbon::now();
            }
        }

        if ($request->has('is_gss_submitted')) {
            $purchaseRequest->is_gss_submitted = $request->input('is_gss_submitted');
            if ($purchaseRequest->is_gss_submitted) {
                $purchaseRequest->submitted_date_gss = Carbon::now();
            }
        }

        // Save the changes
        $purchaseRequest->save();

        // Return a response
        return response()->json(['message' => 'Purchase request updated successfully']);
    }


    // GENERATE REPORTS
    public function exportToExcel($data)
    {
        // Load the existing Excel template
        $templatePath = public_path('templates/purchase_request_template.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);

        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Define column headers
        $headers = ['pr_no', 'serial_no', 'procurement'];

        // Initialize row counter
        $row = 11; // Assuming your data starts from the second row in the template
        $particulars = $data[0]['particulars'];
        $pr_date = Carbon::createFromFormat('Y-m-d', $data[0]['pr_date'])->format('F d, Y');
        $office = $data[0]['office'];
        $signatories = $data[0]['signatory'];
        $designation = $data[0]['designation'];

        $sheet->setCellValueByColumnAndRow(2, 36, $particulars);
        $sheet->setCellValueByColumnAndRow(5, 7, "Date:" . $pr_date);
        $sheet->setCellValueByColumnAndRow(2, 7, $office);
        $sheet->setCellValueByColumnAndRow(2, 42, $signatories);
        $sheet->setCellValueByColumnAndRow(2, 43, $designation);
        $sheet->setCellValueByColumnAndRow(6, 35, "=SUM(F11:F34)");

        // Iterate through data
        foreach ($data as $rowData) {
            // Iterate through columns
            foreach ($data as $index => $field) {
                // Set the cell value using the field name and row index
                $sheet->setCellValueByColumnAndRow(1, $row, $rowData['serial_no']);
                $sheet->setCellValueByColumnAndRow(2, $row, $rowData['unit']);
                $sheet->setCellValueByColumnAndRow(3, $row, $rowData['procurement']);
                $sheet->setCellValueByColumnAndRow(4, $row, $rowData['quantity']);
                $sheet->setCellValueByColumnAndRow(5, $row, $rowData['app_price']);
                $sheet->setCellValueByColumnAndRow(6, $row, $rowData['quantity'] * $rowData['app_price']);
            }
            // Increment the row counter
            $row++;
        }
        $sheet->getProtection()->setPassword('dilg4a@2024');

        // Create a writer and save the spreadsheet to a new file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = $data[0]['pr_no'] . '.xlsx';
        $writer->save($fileName);

        // Download the file and delete it after sending
        return response()->download($fileName)->deleteFileAfterSend(true);
    }




    public function total_amount(Request $request)
    {
        $id = $request->input('id');

        $query = PurchaseRequestModel::select(
            'pr.id AS id',
            DB::raw('SUM(app.app_price * pr_items.qty) AS total_amount')
        )
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.id')
            ->leftJoin('tbl_status as status', 'status.id', '=', 'pr.stat')
            ->where('pr.id', $id)
            ->groupBy('pr.id')
            ->get();

        // Dump and die to output the SQL and the result for debugging
        // dd($query);

        // If you want to return the result as JSON
        return response()->json($query);
    }
    public function countCancelledPR($userId)
    {
        return response()->json(PurchaseRequestModel::select(PurchaseRequestModel::raw('count(*) as cancelled_pr'))
            ->where('stat', 7)
            ->where('action_officer', $userId)
            ->get());
    }

    public function countUserTotalPR($userId)
    {
        return response()->json(PurchaseRequestModel::select(PurchaseRequestModel::raw('count(*) as total_pr'))
            ->where('action_officer', $userId)
            ->get());
    }

    public function fetchCartItemInfo($itemSelected)
    {

        return response()->json(AppItemModel::select(AppItemModel::raw('unit.item_unit_title as `unit`,tbl_app.app_price'))
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->where('tbl_app.id', $itemSelected)
            ->get());
    }

    public function post_update_cart(Request $request)
    {
        PurchaseRequestItemModel::where('pr_id', $request->input('pr_id'))
            ->where('pr_item_id', $request->input('pr_item_id'))
            ->update([
                'qty' => $request->input('qty'),
                'description' => $request->input('desc'),
                'pr_item_id' => $request->input('sel_app_id')
            ]);
        return response()->json(['message' => 'Cart details updated successfully']);
    }
    public function post_update_status(Request $request)
    {
        if (!is_array($request->input('pr_id')) || $request->input('status') == 2) {

            PurchaseRequestModel::where('id', $request->input('pr_id'))
                ->update([
                    'stat' => $request->input('status'),
                    'submitted_date_budget' => Carbon::now(), // Set 'submitted_date_budget' to current date and time
                ]);
        } else {

            PurchaseRequestModel::whereIn('id', $request->input('pr_id'))
                ->update([
                    'stat' => $request->input('status'),
                ]);
        }

        // DB::enableQueryLog();

        // dd(DB::getQueryLog());

        return response()->json(['message' => 'Purchase Request updated successfully']);
    }

    public function countPurchaseRequestStatistics($cur_year)
    {
        return response()->json(
            PurchaseRequestModel::select(
                PurchaseRequestModel::raw('COUNT(*) as total_pr'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 1 THEN 1 END) as draft'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 2 THEN 1 END) as submitted_to_budget'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 3 THEN 1 END) as received_by_budget'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 4 THEN 1 END) as submitted_to_gss'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 5 THEN 1 END) as received_by_gss'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 6 THEN 1 END) as with_rfq'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 7 THEN 1 END) as awarded'),
                PurchaseRequestModel::raw('COUNT(CASE WHEN stat = 8 THEN 1 END) as with_purchase_order'),
            )
                ->whereYear('date_added', 2024)
                ->get()
        );
    }

    public function getPurchaseRequest(Request $request)
    {
        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('id,pr_no,purpose,submitted_date_budget'))
            ->where('stat', SUBMITTED_TO_BUDGET);
        $pr_opts = $query->get();
        return response()->json($pr_opts);
    }
    public function post_addCode(Request $request)
    {

        // Update the record
        PurchaseRequestModel::where('id', $request->input('id'))
            ->update([
                'availability_code' => $request->input('code'),
                'stat' => RECEIVED_BY_BUDGET
            ]);


        // You can return a response, if needed
        return response()->json(['message' => 'Purchase request details updated successfully']);
    }
}
