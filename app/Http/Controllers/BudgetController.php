<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
use App\Models\ObligationModel;
use App\Models\ObjectCodeModel;
use App\Models\SupplierModel;


const SUBMITTED_TO_BUDGET = 2;
const SUBMITTED_TO_GSS = 4;
const RECEIVED_BY_GSS = 5;
const RECEIVED_BY_BUDGET = 3;
const WITH_RFQ = 6;
const AWARDED = 7;
const WITH_PO = 8;

class BudgetController extends Controller
{
    public function fetchSUpplier(){
        return response()->json(
            SupplierModel::select(
                'id',
                'supplier_title',
                'supplier_address'
            )
            ->get()
        );
    }
    public function postObligation(Request $request)
    {
        $postObligation = new ObligationModel([
            'type' => $request->type,
            'serial_no' => $request->serial_no,
            'po_id' => $request->po_code,
            'address' => $request->address,
            'purpose' => $request->purpose,
            'amount' => $request->amount,
            'supplier' => $request->supplier_title,
        ]);
        $postObligation->save();
        return response()->json($postObligation);
    }
    
    public function fetchObligationData($id)
    {
        $data = ObligationModel::select(
            'tbl_obligation.id',
            'tbl_obligation.type',
            'tbl_obligation.serial_no',
            'tbl_obligation.po_id',
            'tbl_obligation.address',
            'tbl_obligation.purpose',
            'tbl_obligation.amount',
            'tbl_obligation.remarks',
            'tbl_obligation.status',
            'tbl_obligation.is_dfunds',
            'tbl_obligation.date_created',
            'tbl_obligation.date_updated',
            'tbl_obligation.date_submitted',
            'tbl_obligation.date_received',
            'tbl_obligation.date_obligated',
            'tbl_obligation.date_returned',
            'tbl_obligation.date_released',
            's.supplier_title as supplier_title',
            'po.po_no as po_code',
            // 'e.employee_no as userid',
            // 'e.username as created_by',
            // 'sb.username as submitted_by',
            // 'rb.username as received_by',
            // 'obl.username as obligated_by',
            // 'rtb.username as returned_by',
            // 'rlb.username as released_by',
            // 'ob.supplier as fallback_supplier',
            // 'em.username as pr_creator',
            // 'em.DIVISION_C as user_division',
        )
            ->leftJoin('po as po', 'po.id', '=', 'tbl_obligation.po_id')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_obligation.supplier')
            ->leftJoin('pr as pr', 'pr.id', '=', 'po.pr_id')
            // ->leftJoin('users as e', 'e.employee_no', '=', 'tbl_obligation.created_by')
            // ->leftJoin('users as sb', 'sb.employee_no', '=', 'tbl_obligation.submitted_by')
            // ->leftJoin('users as rb', 'rb.employee_no', '=', 'tbl_obligation.received_by')
            // ->leftJoin('users as obl', 'obl.employee_no', '=', 'tbl_obligation.obligated_by')
            // ->leftJoin('users as rtb', 'rtb.employee_no', '=', 'tbl_obligation.returned_by')
            // ->leftJoin('users as rlb', 'rlb.employee_no', '=', 'tbl_obligation.released_by')
            // ->leftJoin('users as em', 'em.employee_no', '=', 'pr.username')
            ->where('tbl_obligation.id', $id)
            ->get();
        return response()->json($data);
    }
    public function postObjectCode(Request $request)
    {
        $postOC = new ObjectCodeModel([
            'code' => $request->code,
            'uacs' => $request->uacs,
        ]);
        $postOC->save();
        return response()->json($postOC);
    }
    public function getPurchaseRequest(Request $request)
    {
        $query = PurchaseRequestModel::select(
            'id',
            'pr_no',
            'purpose',
            'is_budget_submitted',
            'submitted_date_budget'
        )
            ->where('is_budget_submitted', 1)
            ->orderBy('submitted_date_budget', 'desc');

        return response()->json($query->get());
    }
    public function fetchObligation()
    {

        $data = ObligationModel::select(
            'tbl_obligation.id',
            'tbl_obligation.type',
            'tbl_obligation.serial_no',
            'tbl_obligation.po_id',
            'tbl_obligation.address',
            'tbl_obligation.purpose',
            'tbl_obligation.amount',
            'tbl_obligation.remarks',
            'tbl_obligation.status',
            'tbl_obligation.is_dfunds',
            'tbl_obligation.date_created',
            'tbl_obligation.date_updated',
            'tbl_obligation.date_submitted',
            'tbl_obligation.date_received',
            'tbl_obligation.date_obligated',
            'tbl_obligation.date_returned',
            'tbl_obligation.date_released',
            's.supplier_title as supplier_title',
            'po.po_no as po_code',
            // 'e.employee_no as userid',
            // 'e.username as created_by',
            // 'sb.username as submitted_by',
            // 'rb.username as received_by',
            // 'obl.username as obligated_by',
            // 'rtb.username as returned_by',
            // 'rlb.username as released_by',
            // 'ob.supplier as fallback_supplier',
            // 'em.username as pr_creator',
            // 'em.DIVISION_C as user_division',
        )
            ->leftJoin('po as po', 'po.id', '=', 'tbl_obligation.po_id')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_obligation.supplier')
            ->leftJoin('pr as pr', 'pr.id', '=', 'po.pr_id')
            // ->leftJoin('users as e', 'e.employee_no', '=', 'tbl_obligation.created_by')
            // ->leftJoin('users as sb', 'sb.employee_no', '=', 'tbl_obligation.submitted_by')
            // ->leftJoin('users as rb', 'rb.employee_no', '=', 'tbl_obligation.received_by')
            // ->leftJoin('users as obl', 'obl.employee_no', '=', 'tbl_obligation.obligated_by')
            // ->leftJoin('users as rtb', 'rtb.employee_no', '=', 'tbl_obligation.returned_by')
            // ->leftJoin('users as rlb', 'rlb.employee_no', '=', 'tbl_obligation.released_by')
            // ->leftJoin('users as em', 'em.employee_no', '=', 'pr.username')
            ->orderBy('tbl_obligation.id', 'desc')
            ->get();
        return response()->json($data);
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
