<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseRequestModel;
use App\Models\PurchaseRequestItemModel;
use App\Models\AppItemModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

const SUBMITTED_TO_BUDGET = 2;
const SUBMITTED_TO_GSS = 4;
const RECEIVED_BY_GSS = 5;
const RECEIVED_BY_BUDGET = 3;
const WITH_RFQ = 6;
const AWARDED = 7;
const WITH_PO = 8;
class PurchaseRequestController extends Controller
{
    public function generatePurchaseRequestNo($cur_year = 2024)
    {

        return response()->json(
            PurchaseRequestModel::select(PurchaseRequestModel::raw('COUNT(*)+1 as "pr_count" '))
                ->whereYear('date_added', $cur_year)
                ->get()
        );
    }
    public function post_insert_purchaseNo(Request $request)
    {
        $pr_opts = new PurchaseRequestModel([
            'id'            => null,
            'pr_no'         => $request->input('pr_no'),
            'stat'          => $request->input('status'),
            'action_officer' => $request->input('user'),
            'current_step'  => $request->input('step'),
            'updated_at'    => null,
            'created_at'    => null

        ]);
        $pr_opts->save();
    }
    public function post_create_purchaseRequest(Request $request)
    {
        // Create a new instance of PurchaseRequestModel
        $purchaseRequest = new PurchaseRequestModel();

        $purchaseRequest->pr_no = $request->input('pr_no');
        $purchaseRequest->pmo = $request->input('pmo');
        $purchaseRequest->type = $request->input('type');
        $purchaseRequest->pr_date = $request->input('pr_date');
        $purchaseRequest->target_date = $request->input('target_date');
        $purchaseRequest->purpose = $request->input('purpose');
        $purchaseRequest->action_officer = $request->input('created_by');

        $purchaseRequest->stat = 1;


        $purchaseRequest->save();


        // Return a response indicating success
        return response()->json(['message' => 'Purchase request created successfully']);
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
    public function getPurchaseRequestDetails(Request $request)
    {
        $pr_no = $request->input('pr_no');

        // Fetch purchase request details based on pr_no
        $purchaseRequest = PurchaseRequestModel::where('pr_no', $pr_no)->first();

        // Check if the purchase request was found
        if ($purchaseRequest) {
            // Return the details as JSON response
            return response()->json([
                'id'        => $purchaseRequest->id,
                'pmo'         => $purchaseRequest->pmo,
                'type'        => $purchaseRequest->type,
                'pr_date'     => $purchaseRequest->pr_date,
                'target_date' => $purchaseRequest->target_date,
                'purpose'     => $purchaseRequest->purpose,
            ]);
        } else {
            // Return an error response if the purchase request was not found
            return response()->json(['error' => 'Purchase request not found'], 404);
        }
    }
    public function post_insert_pritem(Request $request)
    {
        $pr_id      = $request->input('pr_id');
        $itemIds    = $request->input('itemIds');
        $desc       = $request->input('description');
        $qty        = $request->input('quantity');
        $abc        = $request->input('quantity') * $request->input('app_price');

        // Check if the PR ID and item ID combination already exists
        $existingItem = PurchaseRequestItemModel::where('pr_id', $pr_id)
            ->where('pr_item_id', $itemIds)
            ->first();

        if ($existingItem) {
            // If the combination exists, update the quantity
            $existingItem->qty += $qty;
            $existingItem->abc = $existingItem->qty * $request->input('app_price'); // Corrected line
            $existingItem->save();
        } else {
            // If the combination doesn't exist, insert a new record
            $pr_opts = new PurchaseRequestItemModel([
                'id'            => null,
                'pr_id'         => $pr_id,
                'pr_item_id'    => $itemIds,
                'description'   => $desc,
                'qty'           => $qty,
                'abc'           => $abc,
                'date_added'    => null,
                'flag'          => null,
            ]);
            $pr_opts->save();
        }

        // Update the current step of the purchase request
        $purchaseRequest = PurchaseRequestModel::where('pr_no', $request->input('pr_no'))->first();
        if ($purchaseRequest) {
            $purchaseRequest->current_step = $request->input('step');
            $purchaseRequest->save();
        }

        // Return a response
        return response()->json(['message' => 'Items added to the database']);
    }

    public function post_remove_pritem(Request $request)
    {
        $itemIds = $request->input('itemIds');

        // Ensure $itemIds is an array
        if (!is_array($itemIds)) {
            $itemIds = [$itemIds];
        }

        // Assuming PurchaseRequestItemModel is the model for your database table
        // Adjust the model and table name accordingly
        PurchaseRequestItemModel::where('pr_id', $request->input('pr_id'))
            ->where('pr_item_id', $itemIds)->delete();

        // You can return a response if needed
        return response()->json(['message' => 'Items removed from the database']);
    }
    public function fetchCart(Request $request)
    {
        $pr_id = $request->input('id');

        // If 'id' is not found in the request input, try to get it from the request body
        if ($pr_id === null) {
            $pr_id = $request->json('id');
        }
        $query = AppItemModel::select(AppItemModel::raw('
        tbl_app.id as `app_id`,
        pr.pr_no as `pr_no`,
        tbl_app.sn as `serial_no`,
        tbl_app.item_title as `procurement`,
        unit.item_unit_title as `unit`,
        pr_items.description as `description`,
        tbl_app.app_price as `app_price`
        '))
            ->leftJoin('pr_items', 'pr_items.pr_item_id', '=', 'tbl_app.id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
            ->where('pr.id', $pr_id);
        // Print the SQL query to check
        // dd($query->toSql());

        // Execute the query and return the result
        $app_item = $query->get();

        return response()->json($app_item);
    }
    public function fetchPurchaseReqData(Request $request)
    {
        $page = $request->query('page');
        $itemsPerPage = $request->query('itemsPerPage', 500);

        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
        pr.id AS `id`,
        MAX(pr.pr_no) AS `pr_no`,
        MAX(pr.action_officer) AS `user_id`,
        MAX(users.last_name) AS `created_by`,
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
        sum(pr_items.qty * app.app_price) as `app_price`
        '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.id')

            ->leftJoin('tbl_status as status', 'status.id', '=', 'pr.stat')
            ->orderBy('pr.id', 'desc')
            ->groupBy('pr.id');

        $prData = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        // Dump and die to output the SQL for debugging
        // dd($prData);
        return response()->json($prData);
    }
    public function fetchSubmittedtoGSS(Request $request)
    {
        $page = $request->query('page');
        $itemsPerPage = $request->query('itemsPerPage', 500);
        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
        pr.id AS `id`,
        MAX(rfq.id) AS `rfq_id`,
        MAX(rfq.rfq_no) AS `rfq_no`,
        MAX(rfq.rfq_date) AS `rfq_date`,
        MAX(pr.pr_no) AS `pr_no`,
        MAX(pr.action_officer) AS `user_id`,
        MAX(users.last_name) AS `created_by`,
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
        sum(pr_items.qty * app.app_price) as `app_price`

        '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.id')
            ->leftJoin('tbl_status as status', 'status.id', '=', 'pr.stat')
            ->leftJoin('tbl_rfq as rfq', 'rfq.pr_id', '=', 'pr.id')
            ->whereIn('pr.stat', [4, 5, 6, 7, 8]) // New where condition using IN operator
            ->orderBy('pr.id', 'desc')
            ->groupBy('pr.id');

        $prData = $query->paginate($itemsPerPage, ['*'], 'page', $page);



        // Dump and die to output the SQL for debugging
        // dd($prData);
        return response()->json($prData);
    }



    public function viewPurchaseRequest($id, Request $request)
    {

        $query = AppItemModel::select(AppItemModel::raw('
        tbl_app.id as `app_id`,
        tbl_app.sn as `serial_no`,
        tbl_app.item_title as `procurement`,
        tbl_app.app_price as `app_price`,
        unit.item_unit_title as `unit`,
        pr_items.description as `description`,
        pr_items.qty as `quantity`,
        pr_items.qty * tbl_app.app_price as `total`,
        pr.pr_no as `pr_no`,
        pmo.pmo_title as `office`,
        pmo.id as `office_id`,
        pmo.pmo_contact_person as  `signatory`,
        pmo.designation as  `designation`,
        pr.type as `type`,
        pr.pr_date as `pr_date`,
        pr.target_date as `target_date`,
        pr.purpose as `particulars`,
        pr.current_step as `step`,
        tbl_status.title as `status`
        '))
            ->leftJoin('pr_items', 'pr_items.pr_item_id', '=', 'tbl_app.id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('tbl_status', 'pr.stat', '=', 'tbl_status.id')
            ->where('pr.id', $id);

        // Print the SQL query to check
        // dd($query->toSql());

        // Execute the query and return the result
        $app_item = $query->get();

        if ($request->has('export')) {
            // Export the data to Excel
            return $this->exportToExcel($app_item);
        }

        return response()->json($app_item);
    }

    public function get_app_details($id)
    {
        // Fetch the application item details based on the provided ID
        $app_item = AppItemModel::select(
            'tbl_app.id as app_id',
            'tbl_app.sn as serial_no',
            'tbl_app.item_title as procurement',
            'tbl_app.app_price as app_price',
            'unit.item_unit_title as unit',
            'unit.id as  unit_id',
        )
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->where('tbl_app.id', $id)
            ->first(); // Use first() to get only one record

        // Check if the item exists
        if (!$app_item) {
            // Return an error response if the item does not exist
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Return the application item details as JSON response
        return response()->json($app_item);
    }



    // GENERATE REPORTS



    private function exportToExcel($data)
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
