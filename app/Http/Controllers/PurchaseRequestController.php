<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\RFQModel;
use App\Models\UserModel;
use App\Models\AppItemModel;
use Illuminate\Http\Request;
use App\Models\AbstractModel;

use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequestModel;
use App\Events\PurchaseRequestUpdated;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\PurchaseRequestItemModel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

const DRAFT = 1;
const SUBMITTED_TO_GSS = 2;
const RECEIVED_BY_GSS = 3;
const APPROVED_BY_GSS = 4;
const SUBMITTED_TO_BUDGET = 5;
const RECEIVED_BY_BUDGET = 6;
const APPROVED_BY_BUDGET = 7;
const SUBMITTED_TO_ORD = 8;
const RECEIVED_BY_ORD = 9;
const APPROVED_BY_ORD = 10;
const RETURNED_BY_GSS = 14;
const RETURNED_BY_BUDGET = 15;
const RETURNED_BY_ORD = 16;
const CANCELLED = 17;

class PurchaseRequestController extends Controller
{
    public function pr_monitoring_stats()
    {
        return response()->json([
            'total_pr' => PurchaseRequestModel::count(),
            'total_rfq' => RFQModel::count(),
            'total_aoq' => AbstractModel::count(),
            'completed_pr' => PurchaseRequestModel::count(),
        ]);
    }

    public function fetchPRMonitor()
    {
        // Step 1: Get all PRs and user info
        $prs = DB::table('pr')
            ->leftJoin('users', 'users.id', '=', 'pr.submitted_by')
            ->leftJoin('tbl_status', 'tbl_status.id', '=', 'pr.stat')
            ->select(
                'pr.id as pr_id',
                'pr.pr_no',
                'pr.purpose',
                'pr.target_date',
                'pr.submitted_by',
                'pr.stat',
                'tbl_status.title as status',
                DB::raw('DATE_FORMAT(pr.pr_date, "%b %d, %Y %h:%i %p") as pr_date'),
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as ferson"),
            )
            ->get()
            ->keyBy('pr_id');

        // Step 2: Get RFQs and expand comma-separated pr_ids
        $rfqs = DB::table('tbl_rfq')->get();
        $rfqExpanded = [];

        foreach ($rfqs as $rfq) {
            $prIds = array_filter(array_map('trim', explode(',', $rfq->pr_id)));
            foreach ($prIds as $prId) {
                $rfqExpanded[] = [
                    'rfq_no' => $rfq->rfq_no,
                    'rfq_id' => $rfq->id,
                    'rfq_date' => \Carbon\Carbon::parse($rfq->rfq_date)->format('M d, Y h:i A'),
                    'abstract_no' => DB::table('tbl_abstract')->where('rfq_id', $rfq->id)->value('abstract_no'),
                    'aoq_id' => DB::table('tbl_abstract')->where('rfq_id', $rfq->id)->value('id'),
                    'abstract_date' => DB::table('tbl_abstract')
                        ->where('rfq_id', $rfq->id)
                        ->selectRaw('DATE_FORMAT(abstract_date, "%b %d, %Y %h:%i %p") as abstract_date')
                        ->value('abstract_date'),
                    'pr_id' => (int)$prId,
                ];
            }
        }

        // Step 3: Track which PRs have RFQ entries
        $final = [];
        $seenPrIds = [];

        foreach ($rfqExpanded as $row) {
            if (isset($prs[$row['pr_id']])) {
                $pr = $prs[$row['pr_id']];
                $seenPrIds[] = $pr->pr_id;

                $final[] = [
                    'pr_id' => $pr->pr_id,
                    'pr_no' => $pr->pr_no,
                    'purpose' => $pr->purpose,
                    'pr_date' => $pr->pr_date,
                    'target_date' => $pr->target_date,
                    'submitted_by' => $pr->submitted_by,
                    'ferson' => $pr->ferson,
                    'rfq_no' => $row['rfq_no'],
                    'rfq_date' => $row['rfq_date'],
                    'abstract_no' => $row['abstract_no'],
                    'abstract_date' => $row['abstract_date'],
                    'aoq_id' => $row['aoq_id'],
                    'rfq_id' => $row['rfq_id'],
                    'status' => $pr->status,
                    'stat' => $pr->stat,
                ];
            }
        }

        // Step 4: Add PRs that do NOT have any RFQ
        foreach ($prs as $prId => $pr) {
            if (!in_array($prId, $seenPrIds)) {
                $final[] = [
                    'pr_id' => $pr->pr_id,
                    'pr_no' => $pr->pr_no,
                    'purpose' => $pr->purpose,
                    'pr_date' => $pr->pr_date,
                    'target_date' => $pr->target_date,
                    'submitted_by' => $pr->submitted_by,
                    'ferson' => $pr->ferson,
                    'rfq_no' => null,
                    'rfq_date' => null,
                    'abstract_no' => null,
                    'abstract_date' => null,
                    'status' => $pr->status,
                    'stat' => $pr->stat,
                ];
            }
        }

        return response()->json($final);
    }

    public function generatePurchaseRequestNo($cur_year = null)
    {
        $cur_year = $cur_year ?? date('Y');

        return response()->json(
            PurchaseRequestModel::select(PurchaseRequestModel::raw('COUNT(*)+1 as "pr_count"'))
                ->whereYear('date_added', $cur_year)
                ->get()
        );
    }
    public function fetchItems(Request $request)
    {
        $userId = $request->input('userId');

        $user = UserModel::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        try {
            $query = AppItemModel::select(
                'tbl_app.id',
                'tbl_app.item_title as name',
                'tbl_app.sn as stockno',
                'unit.item_unit_title as unit',
                'tbl_app.app_year as AppYear'
            )
                ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
                ->where('tbl_app.app_status', 'approve');

            if ($user->user_role !== 'gss_admin') {
                $query->where('tbl_app.pmo_id', $user->pmo_id);
            }

            $items = $query->get();

            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching items'], 500);
        }
    }

    public function fetchPurchaseReqData(Request $request)
    {
        $page = $request->query('page', 1);
        $itemsPerPage = $request->query('itemsPerPage', 50); // Reduced default for performance

        $userId = $request->input('user_id');
        $user = UserModel::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $prNo = $request->input('pr_no');
        $prDate = $request->input('pr_date');
        $pmo = $request->input('pmo');
        $status = $request->input('status');

        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
            pr.id AS `id`,
            MAX(pr.pr_no) AS `pr_no`,
            MAX(pr.action_officer) AS `user_id`,
            CONCAT(MAX(users.first_name), " ", MAX(users.last_name)) AS `created_by`,
            MAX(pr.current_step) AS `step`,
            MAX(pmo.pmo_title) AS `office`,
            MAX(pr.submitted_by) AS `submitted_by`,
            MAX(pr.purpose) AS `particulars`,
            MAX(pr.pr_date) AS `pr_date`,
            MAX(pr.target_date) AS `target_date`,
            MAX(pr.is_urgent) AS `is_urgent`,
            MAX(pr_items.qty) AS `quantity`,
            SUM(pr_items.abc) AS `app_price`,
            MAX(pr_items.description) AS `desc`,
            MAX(mode.mode_of_proc_title) AS `type`,
            MAX(app.sn) AS `serial_no`,
            MAX(app.item_title) AS `item_title`,
            MAX(unit.item_unit_title) AS `unit`,
            MAX(status.title) AS `status`,
            MAX(status.id) AS `status_id`,
            MAX(pr.is_gss_submitted) AS `is_gss_submitted`,
            MAX(pr.is_budget_submitted) AS `is_budget_submitted`,
            MAX(pr.is_ord_submitted) AS `is_ord_submitted`
        '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id')
            ->leftJoin('tbl_status as status', 'status.id', '=', 'pr.stat')
            ->orderBy('pr.id', 'desc')
            ->groupBy('pr.id');

        if ($user->user_role === 'gss_admin') {
            $query->whereIn('pr.stat', [
                SUBMITTED_TO_GSS, // 2
                RECEIVED_BY_GSS,  // 3
                APPROVED_BY_GSS,  // 4
                RETURNED_BY_GSS   // 14
            ]);
        } elseif ($user->user_role === 'budget_admin') {
            $query->whereIn('pr.stat', [
                SUBMITTED_TO_BUDGET,
                RECEIVED_BY_BUDGET,
                APPROVED_BY_BUDGET,
                RETURNED_BY_BUDGET
            ]);
        } elseif ($user->user_role === 'ord_admin') {
            $query->whereIn('pr.stat', [
                SUBMITTED_TO_ORD,
                RECEIVED_BY_ORD,
                APPROVED_BY_ORD,
                RETURNED_BY_ORD
            ]);
        }

        if ($prNo) {
            $query->where('pr.pr_no', 'like', '%' . $prNo . '%');
        }
        if ($prDate) {
            $query->whereDate('pr.pr_date', $prDate);
        }
        if ($pmo) {
            $query->where('pmo.pmo_title', 'like', '%' . $pmo . '%');
        }
        if ($status) {
            $query->where('status.title', 'like', '%' . $status . '%');
        }

        if (!in_array($user->user_role, ['gss_admin', 'budget_admin', 'ord_admin'])) {
            $query->where('pr.action_officer', $user->id);
        }

        try {
            $prData = $query->paginate($itemsPerPage, ['*'], 'page', $page);

            return response()->json($prData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching data.', 'details' => $e->getMessage()], 500);
        }
    }

    public function perUserPurchaseReqData(Request $request)
    {
        $page = $request->query('page', 1);
        $itemsPerPage = $request->query('itemsPerPage', 10000);

        $userId = $request->input('user_id');
        $user = UserModel::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
            pr.id AS `id`,
            MAX(pr.pr_no) AS `pr_no`,
            MAX(pr.action_officer) AS `user_id`,
            CONCAT(MAX(users.first_name), " ", MAX(users.last_name)) AS `created_by`,
            MAX(pr.current_step) AS `step`,
            MAX(pmo.pmo_title) AS `office`,
            MAX(pr.submitted_by) AS `submitted_by`,
            MAX(pr.purpose) AS `particulars`,
            MAX(pr.pr_date) AS `pr_date`,
            MAX(pr.target_date) AS `target_date`,
            MAX(pr.is_urgent) AS `is_urgent`,
            SUM(pr_items.abc) AS `app_price`,
            MAX(pr_items.qty) AS `quantity`,
            MAX(pr_items.description) AS `desc`,
            MAX(mode.mode_of_proc_title) AS `type`,
            MAX(app.sn) AS `serial_no`,
            MAX(app.item_title) AS `item_title`,
            MAX(unit.item_unit_title) AS `unit`,
            MAX(status.title) AS `status`,
            MAX(status.id) AS `status_id`
        '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id')
            ->leftJoin('tbl_status as status', 'status.id', '=', 'pr.stat')
            ->orderBy('pr.id', 'desc')
            ->groupBy('pr.id');

        if (!in_array($user->user_role, ['gss_admin', 'budget_admin','ord_admin'])) {
            $query->where('pr.action_officer', $user->id);
        }

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
                pr.purpose AS `particulars`,
                pr.pr_date AS `pr_date`,
                pr.target_date AS `target_date`,
                pr.is_urgent AS `is_urgent`
            '))
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->where('pr.id', $id)
            ->first();

        if (!$query) {
            return response()->json(['message' => 'Purchase request not found'], 404);
        }

        $prItems = PurchaseRequestItemModel::where('pr_id', $id)
            ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'app.unit_id')
            ->select(
                'pr_items.id',
                'pr_items.qty',
                'pr_items.unit_cost',
                'pr_items.abc',
                'pr_items.description',
                'app.sn as serial_no',
                'app.item_title as item_title',
                'unit.item_unit_title as unit'
            )
            ->get();

        return response()->json([
            'purchaseRequest' => $query,
            'prItems' => $prItems
        ]);
    }

    public function post_create_purchaseRequest(Request $request)
    {
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
                $unitCost = isset($item['price']) ? floatval($item['price']) : 0;
                $abc = $item['quantity'] * $unitCost;

                $existingItem = PurchaseRequestItemModel::where('pr_id', $pr_id)
                    ->where('pr_item_id', $item['id'])
                    ->first();

                if ($existingItem) {
                    $existingItem->qty += $item['quantity'];
                    $existingItem->unit_cost = $unitCost;
                    $existingItem->abc = $existingItem->qty * $unitCost;
                    $existingItem->save();
                } else {
                    PurchaseRequestItemModel::create([
                        'pr_id' => $pr_id,
                        'pr_item_id' => $item['id'],
                        'description' => $item['description'],
                        'qty' => $item['quantity'],
                        'unit_cost' => $unitCost,
                        'abc' => $abc,
                        'date_added' => now(),
                        'flag' => 1,
                    ]);
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

            $purchaseRequest->update([
                'pmo' => $request->input('pmo'),
                'type' => $request->input('type'),
                'pr_date' => $request->input('pr_date'),
                'target_date' => $request->input('target_date'),
                'purpose' => $request->input('purpose'),
            ]);

            $validatedData = $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'nullable|integer',
                'items.*.qty' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.descrip' => 'nullable|string',
            ]);

            $items = $validatedData['items'];
            $processedIds = [];

            foreach ($items as $item) {
                $unitCost = isset($item['price']) ? floatval($item['price']) : 0;
                $abc = $item['qty'] * $unitCost;

                $existingItem = PurchaseRequestItemModel::find($item['id'] ?? null);

                if ($existingItem) {
                    $existingItem->update([
                        'description' => $item['descrip'],
                        'qty' => $item['qty'],
                        'unit_cost' => $unitCost,
                        'abc' => $abc,
                        'date_added' => now(),
                        'flag' => 1,
                    ]);
                    $processedIds[] = $existingItem->id;
                } else {
                    $newItem = PurchaseRequestItemModel::create([
                        'pr_id' => $purchaseRequest->id,
                        'pr_item_id' => $item['id'] ?? null,
                        'description' => $item['descrip'],
                        'qty' => $item['qty'],
                        'unit_cost' => $unitCost,
                        'abc' => $abc,
                        'date_added' => now(),
                        'flag' => 1,
                    ]);
                    $processedIds[] = $newItem->id;
                }
            }

            PurchaseRequestItemModel::where('pr_id', $purchaseRequest->id)
                ->whereNotIn('id', $processedIds)
                ->delete();

            DB::commit();

            return response()->json([
                'message' => 'Purchase request and items updated successfully.',
                'items' => PurchaseRequestItemModel::where('pr_id', $purchaseRequest->id)->get(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Update failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePurchaseRequestStatus(Request $request)
    {
        $purchaseRequest = PurchaseRequestModel::find($request->input('id'));

        if (!$purchaseRequest) {
            return response()->json(['message' => 'Purchase request not found'], 404);
        }

        $user = UserModel::find($request->input('submitted_by'));
        $userRole = $user ? $user->user_role : null;
        $currentStat = $purchaseRequest->stat;

        $validTransitions = [
            DRAFT => [SUBMITTED_TO_GSS, CANCELLED],
            SUBMITTED_TO_GSS => [RECEIVED_BY_GSS, RETURNED_BY_GSS],
            RECEIVED_BY_GSS => [APPROVED_BY_GSS, RETURNED_BY_GSS],
            APPROVED_BY_GSS => [SUBMITTED_TO_BUDGET, RETURNED_BY_GSS],
            SUBMITTED_TO_BUDGET => [RECEIVED_BY_BUDGET, RETURNED_BY_BUDGET],
            RECEIVED_BY_BUDGET => [APPROVED_BY_BUDGET, RETURNED_BY_BUDGET],
            APPROVED_BY_BUDGET => [SUBMITTED_TO_ORD, RETURNED_BY_BUDGET],
            SUBMITTED_TO_ORD => [RECEIVED_BY_ORD, RETURNED_BY_ORD],
            RECEIVED_BY_ORD => [APPROVED_BY_ORD, RETURNED_BY_ORD],
            APPROVED_BY_ORD => [],
            RETURNED_BY_GSS => [SUBMITTED_TO_GSS, CANCELLED],
            RETURNED_BY_BUDGET => [SUBMITTED_TO_BUDGET, CANCELLED],
            RETURNED_BY_ORD => [SUBMITTED_TO_ORD, CANCELLED],
            CANCELLED => [],
        ];

        DB::beginTransaction();
        try {
            if ($request->has('status') && $request->input('status') === 'return') {
                $newStat = $currentStat;

                if ($userRole === 'gss_admin' && in_array($currentStat, [RECEIVED_BY_GSS, APPROVED_BY_GSS])) {
                    $newStat = RETURNED_BY_GSS;
                    $purchaseRequest->is_gss_submitted = false;
                    $purchaseRequest->submitted_date_gss = null;
                } elseif ($userRole === 'budget_admin' && in_array($currentStat, [SUBMITTED_TO_BUDGET, RECEIVED_BY_BUDGET, APPROVED_BY_BUDGET])) {
                    $newStat = RETURNED_BY_BUDGET;
                    $purchaseRequest->is_budget_submitted = false;
                    $purchaseRequest->submitted_date_budget = null;
                } elseif ($userRole === 'ord_admin' && in_array($currentStat, [SUBMITTED_TO_ORD, RECEIVED_BY_ORD, APPROVED_BY_ORD])) {
                    $newStat = RETURNED_BY_ORD;
                    $purchaseRequest->is_ord_submitted = false;
                    $purchaseRequest->submitted_date_ord = null;
                } else {
                    return response()->json(['message' => 'Invalid return request for user role or status'], 400);
                }

                $purchaseRequest->stat = $newStat;
            } else {
                $newStatus = $request->has('status') ? (int)$request->input('status') : $currentStat;
                if (!isset($validTransitions[$currentStat]) || !in_array($newStatus, $validTransitions[$currentStat])) {
                    return response()->json(['message' => 'Invalid status transition'], 400);
                }
                $purchaseRequest->stat = $newStatus;

                if ($newStatus === CANCELLED && !in_array($currentStat, [DRAFT, RETURNED_BY_GSS, RETURNED_BY_BUDGET, RETURNED_BY_ORD])) {
                    return response()->json(['message' => 'Cannot cancel from this status'], 400);
                }

                if ($request->has('is_gss_submitted')) {
                    $purchaseRequest->is_gss_submitted = (bool)$request->input('is_gss_submitted');
                    if ($purchaseRequest->is_gss_submitted) {
                        $purchaseRequest->submitted_by_gss = $request->input('submitted_by_gss');
                        $purchaseRequest->submitted_date_gss = Carbon::now();
                    }
                }

                if ($request->has('is_budget_submitted')) {
                    $purchaseRequest->is_budget_submitted = (bool)$request->input('is_budget_submitted');
                    if ($purchaseRequest->is_budget_submitted) {
                        $purchaseRequest->submitted_by = $request->input('submitted_by');
                        $purchaseRequest->submitted_date_budget = Carbon::now();
                    }
                }

                if ($request->has('is_ord_submitted')) {
                    $purchaseRequest->is_ord_submitted = (bool)$request->input('is_ord_submitted');
                    if ($purchaseRequest->is_ord_submitted) {
                        $purchaseRequest->submitted_by = $request->input('submitted_by');
                        $purchaseRequest->submitted_date_ord = Carbon::now();
                    }
                }
            }

            $statusTitle = DB::table('tbl_status')->where('id', $purchaseRequest->stat)->value('title');
            if ($statusTitle) {
                $purchaseRequest->status = $statusTitle;
            }

            $purchaseRequest->save();

            event(new PurchaseRequestUpdated(
                $purchaseRequest->id,
                $purchaseRequest->stat,
                $purchaseRequest->pr_no,
                $request->input('submitted_by'),
                $userRole,
                $purchaseRequest->created_by, // Use created_by for createdById
                $purchaseRequest->action_officer // Use action_officer for actionOfficerId
            ));

            DB::commit();

            return response()->json(['message' => 'Purchase request updated successfully', 'data' => $purchaseRequest]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update purchase request', 'error' => $e->getMessage()], 500);
        }
    }

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

    public function exportPurchaseRequest(Request $request, $id)
    {
        $query = DB::table('pr')
            ->select([
                'pr.id AS id',
                'pr.type',
                'pr.pr_no',
                'pr.action_officer',
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'pmo.id AS office',
                'pmo.pmo_title',
                'pmo.pmo_contact_person',
                'pmo.designation',
                'pr.purpose AS particulars',
                'pr.pr_date',
                'pr.target_date',
                'pr.is_urgent',
                'pr_items.id AS item_id',
                'pr_items.qty AS quantity',
                'pr_items.description AS desc',
                'app.sn AS serial_no',
                'app.item_title',
                'unit.item_unit_title AS unit',
                'pr_items.unit_cost AS price'
            ])
            ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('tbl_app AS app', 'app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit AS unit', 'unit.id', '=', 'app.unit_id')
            ->where('pr.id', $id)
            ->get();

        if ($query->isEmpty()) {
            return response()->json(['error' => 'Purchase Request not found.'], 404);
        }

        $templatePath = public_path('templates/purchase_request_template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('C7', 'PR No.: ' . $query[0]->pr_no);
        $sheet->setCellValue('E7', 'Date: ' . Carbon::parse($query[0]->pr_date)->format('F d, Y'));
        $sheet->setCellValue('B7', $query[0]->pmo_title);
        $sheet->setCellValue('B23', $query[0]->particulars);
        $sheet->setCellValue('B29', strtoupper($query[0]->pmo_contact_person));
        $sheet->setCellValue('B30', $query[0]->designation);

        $startRow = 11;
        $maxRows = 12;
        $itemCount = count($query);

        if ($itemCount > $maxRows) {
            $rowsToInsert = $itemCount - $maxRows;
            $sheet->insertNewRowBefore($startRow + $maxRows, $rowsToInsert);
        }

        $row = $startRow;
        $totalAmount = 0;

        foreach ($query as $item) {
            $sheet->setCellValue('A' . $row, $item->serial_no);
            $sheet->setCellValue('B' . $row, $item->unit);

            $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
            $bold = $richText->createTextRun(strtoupper($item->item_title));
            $bold->getFont()->setBold(true);
            $richText->createText("\n\n" . ucwords($item->desc));

            $sheet->setCellValue('C' . $row, $richText);
            $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValue('D' . $row, $item->quantity);

            $sheet->setCellValue('E' . $row, '₱ ' . number_format($item->price, 2));
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('E' . $row)->getFont()->setBold(false);

            $amount = $item->quantity * $item->price;
            $sheet->setCellValue('F' . $row, '₱ ' . number_format($amount, 2));
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('F' . $row)->getFont()->setBold(false);

            $sheet->getRowDimension($row)->setRowHeight(-1);

            $totalAmount += $amount;
            $row++;
        }

        $sheet->setCellValue('F22', '₱ ' . number_format($totalAmount, 2));
        $sheet->getStyle('F22')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F22')->getFont()->setBold(false);

        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setPassword('dilg4a@2024');

        $fileName = "PurchaseRequest_" . $query[0]->pr_no . ".xlsx";
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'PurchaseRequest');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName, [
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ])->deleteFileAfterSend(true);
    }

    public function getDepartmentOverview()
    {
        try {
            $monthlyData = PurchaseRequestItemModel::select(
                DB::raw('SUM(pr_items.abc) as total_abc'),
                'pmo.id as office',
                'pmo.pmo_title'
            )
                ->leftJoin('pr', 'pr_items.pr_id', '=', 'pr.id')
                ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
                ->whereYear('pr_items.date_added', Carbon::now()->year)
                ->whereNotIn('pr.stat', [1, 9])
                ->groupBy('pmo.id', 'pmo.pmo_title')
                ->orderBy('total_abc', 'DESC')
                ->get();

            return response()->json($monthlyData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMonthlyOverview()
    {
        $monthlyData = PurchaseRequestItemModel::select(
            DB::raw('SUM(pr_items.abc) as total_abc'),
            DB::raw('MONTH(pr_items.date_added) as month')
        )
            ->join('pr', 'pr_items.pr_id', '=', 'pr.id')
            ->whereYear('pr_items.date_added', Carbon::now()->year)
            ->whereNotIn('pr.stat', [1, 9])
            ->groupBy(DB::raw('MONTH(pr_items.date_added)'))
            ->orderBy(DB::raw('MONTH(pr_items.date_added)'))
            ->get();

        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = [
                'month' => Carbon::create()->month($i)->format('F'),
                'total_abc' => $monthlyData->firstWhere('month', $i)->total_abc ?? 0,
            ];
        }

        return response()->json($formattedData);
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

        return response()->json($query);
    }

    public function countCancelledPR($userId)
    {
        return response()->json(PurchaseRequestModel::select(PurchaseRequestModel::raw('count(*) as cancelled_pr'))
            ->where('stat', CANCELLED)
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
