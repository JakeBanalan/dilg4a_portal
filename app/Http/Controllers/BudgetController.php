<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;


const SUBMITTED_TO_BUDGET = 2;
const SUBMITTED_TO_GSS = 4;
const RECEIVED_BY_GSS = 5;
const RECEIVED_BY_BUDGET = 3;
const WITH_RFQ = 6;
const AWARDED = 7;
const WITH_PO = 8;

class BudgetController extends Controller
{
    public function getPurchaseRequest(Request $request)
    {
        $page = $request->query('page', 1);
        $itemsPerPage = $request->query('itemsPerPage', 1000);

        $query = PurchaseRequestModel::select('id', 'pr_no', 'purpose', 'is_budget_submitted','submitted_date_budget') // Fixed column name
            ->where('is_budget_submitted', 1);

        try {
            $prData = $query->paginate($itemsPerPage, ['*'], 'page', $page);
            return response()->json($prData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.'], 500);
        }
    }

    public function getPurchaseOrder()
    {

        $result = DB::table('tbl_supplier_quotation')
            ->select('s.id', 's.supplier_title', 'po.po_no', DB::raw('SUM(tbl_supplier_quotation.quotation) AS total_quotation'))
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->leftJoin('tbl_abstract as a', 'a.rfq_id', '=', 'tbl_supplier_quotation.rfq_id')
            ->leftJoin('tbl_purchase_order as po', 'po.abstract_id', '=', 'a.id')
            ->where('tbl_supplier_quotation.winner', 1)
            ->groupBy('s.id', 's.supplier_title', 'po.po_no')
            ->get();
        return response()->json($result);
    }


    public function insertCode(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get the purchase request
            $purchaseRequest = PurchaseRequestModel::find($request->input('id'));

            if (!$purchaseRequest) {
                return response()->json(['message' => 'Purchase request not found'], 404);
            }

            // Add this: Update the code field
            $purchaseRequest->availability_code = $request->input('availability_code');
            $purchaseRequest->save();


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update purchase request and items'], 500);
        }
    }
}
