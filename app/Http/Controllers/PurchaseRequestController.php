<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AppItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
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
        // dd($request->all());
        try {
            DB::beginTransaction();
            $purchaseRequest = new PurchaseRequestModel();

            $purchaseRequest->pr_no = $request->input('pr_no');
            $purchaseRequest->pmo = $request->input('pmo');
            $purchaseRequest->type = $request->input('type');
            $purchaseRequest->pr_date = $request->input('pr_date');
            $purchaseRequest->target_date = $request->input('target_date');
            $purchaseRequest->purpose = $request->input('purpose');
            $purchaseRequest->action_officer = $request->input('created_by');
            $purchaseRequest->is_urgent = $request->input('isUrgent');
            $purchaseRequest->stat = 1;

            $purchaseRequest->save();

            $pr_id = $purchaseRequest->id;

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
                        'date_added'    => now(),
                        'flag'          => 1,
                    ]);
                    $pr_opts->save();
                }
            }


            $purchaseRequest->current_step = $request->input('step');
            $purchaseRequest->save();

            DB::commit();

            return response()->json(['message' => 'Purchase request and items created successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to create purchase request and items'], 500);
        }
    }

    public function post_update_purchaseRequest(Request $request)
    {
        DB::beginTransaction();

        try {
            $purchaseRequest = PurchaseRequestModel::find($request->input('pr_id'));
            if (!$purchaseRequest) {
                return response()->json(['message' => 'Purchase request not found'], 404);
            }

            // Validate the items array
            $validatedData = $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required|integer',
                'items.*.qty' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.descrip' => 'nullable|string',
            ]);

            // Update or add items (if any)
            $items = $validatedData['items'];
            foreach ($items as $item) {
                $existingItem = PurchaseRequestItemModel::find($item['id']);

                if ($existingItem) {
                    // Update the existing item
                    $existingItem->update([
                        'qty' => $item['qty'],
                        'abc' => $item['qty'] * $item['price'],
                        'description' => $item['descrip'],
                    ]);
                } else {

                    $isDuplicate = PurchaseRequestItemModel::where('pr_id', $purchaseRequest->id)
                        ->where('pr_item_id', $item['id'])
                        ->exists();

                    if (!$isDuplicate) {
                        PurchaseRequestItemModel::create([
                            'pr_id' => $purchaseRequest->id,
                            'pr_item_id' => $item['id'],
                            'description' => $item['descrip'],
                            'qty' => $item['qty'],
                            'abc' => $item['qty'] * $item['price'],
                            'date_added' => now(),
                            'flag' => 1,
                        ]);
                    }
                }
            }


            DB::commit();

            return response()->json([
                'message' => 'Purchase request items updated successfully',
                'items' => PurchaseRequestItemModel::where('pr_id', $purchaseRequest->id)->get(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update purchase request items'], 500);
        }
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
        // Get the main purchase request details
        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
                pr.id AS `id`,
                pr.type AS `type`,
                pr.pr_no AS `pr_no`,
                pr.action_officer AS `user_id`,
                users.last_name AS `created_by`,
                pmo.id AS `office`,
                pr.purpose AS `particulars`,
                pr.pr_date AS `pr_date`,
                pr.target_date AS `target_date`,
                pr.is_urgent AS `is_urgent`,
                pr_items.id,
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

        // If no purchase request is found, return a 404 response
        if (!$query) {
            return response()->json(['message' => 'Purchase request not found'], 404);
        }

        // Get related pr_items
        $prItems = PurchaseRequestItemModel::where('pr_id', $id)
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id')
            ->select('pr_items.*', 'app.app_price AS price', 'app.sn as serial_no', 'app.item_title as item_title', 'unit.item_unit_title as unit')
            ->get();

        // Return the data in a structured format
        return response()->json([
            'purchaseRequest' => $query,
            'prItems' => $prItems
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


        $purchaseRequest->save();


        return response()->json(['message' => 'Purchase request updated successfully']);
    }

    //Removed Items
    public function deletePurchaseRequestItem(Request $request)
    {
        try {

            $item_id = $request->input('item_id');

            $item = PurchaseRequestItemModel::find($item_id);

            if ($item) {

                $item->delete();


                return response()->json(['message' => 'Item deleted successfully.']);
            } else {

                return response()->json(['message' => 'Item not found'], 404);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to delete item.'], 500);
        }
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
}
