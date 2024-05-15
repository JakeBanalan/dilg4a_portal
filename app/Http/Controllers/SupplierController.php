<?php

namespace App\Http\Controllers;

use App\Models\RFQModel;
use Illuminate\Http\Request;
use App\Models\SupplierModel;
use App\Models\SupplierQuotationModel;
use App\Models\PurchaseRequestModel;
use App\Models\AbstractModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class SupplierController extends Controller
{
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


    public function fetch_supplier()
    {
        return response()->json(
            SupplierModel::select(SupplierModel::raw('supplier.id,supplier.supplier_title'))
                ->get()
        );
    }
    public function fetch_app_item(Request $req)
    {
        $id = $req->input('id');
        
        $query = RFQModel::select('a.item_title', 'a.app_price', 'pi.qty', 'pi.pr_item_id')
            ->leftJoin('pr as p', 'p.id', '=', 'tbl_rfq.pr_id')
            ->leftJoin('pr_items as pi', 'pi.pr_id', '=', 'p.id')
            ->leftJoin('tbl_app as a', 'a.id', '=', 'pi.pr_item_id')
            ->where('tbl_rfq.rfq_no', '=', $id)
            ->get();
        // dd($query->toSql());

        return response()->json($query);
    }
    public function fetch_app_item_details(Request $req)
    {


        $id = $req->input('id');

        $query = RFQModel::query()
            ->selectRaw(
                'MAX(p.id) as id,
                MAX(p.pr_no) as pr_no,
                MAX(tbl_rfq.id) as rfq_id,
                MAX(tbl_rfq.rfq_no) as rfq_no,
                MAX(aa.abstract_no) as abstract_no,
                MAX(aa.date_created) as abstract_date,
                MAX(p.pr_date) as pr_date,
                MAX(p.purpose) as particulars,
                MAX(tbl_rfq.rfq_date) as rfq_date,
                MAX(pmo.pmo_title) as pmo_title,
                MAX(a.item_title) as item_title,
                MAX(a.app_price) as app_price,
                MAX(pi.qty) as qty,
                MAX(pi.pr_item_id) as pr_item_id,
                MAX(p.stat) as current_status,
                MAX(po.po_no) as po_no,
                MAX(po.po_date) as po_date,
                MAX(po.po_amount) as po_amount,
                SUM(a.app_price * pi.qty) as total_abc'
            )
            ->from('pr as p')
            ->join('tbl_rfq', function ($join) {
                $join->on('p.id', '=', 'tbl_rfq.pr_id');
            })
            ->join('pr_items as pi', function ($join) {
                $join->on('pi.pr_id', '=', 'p.id');
            })
            ->join('tbl_app as a', function ($join) {
                $join->on('a.id', '=', 'pi.pr_item_id');
            })
            ->join('pmo', function ($join) {
                $join->on('pmo.id', '=', 'p.pmo');
            })
            ->join('tbl_abstract as aa', function ($join) {
                $join->on('aa.rfq_no', '=', 'tbl_rfq.rfq_no');
            })
            ->join('tbl_purchase_order as po', function ($join) {
                $join->on('po.abstract_id', '=', 'aa.id');
            })
            ->where(function ($query) use ($id) {
                $query->where('tbl_rfq.id', '=', $id)
                    ->orWhere('aa.id', '=', $id);
            })
            ->get();
        // dd($query->toSql());

        return response()->json($query);
    }
    public function fetch_supplier_title(Request $req)
    {
        $id = $req->input('id');
        $query = SupplierQuotationModel::select('s.supplier_title')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->leftJoin('tbl_rfq as r', 'r.id', '=', 'tbl_supplier_quotation.rfq_id')
            ->leftJoin('tbl_app as a', 'a.id', '=', 'tbl_supplier_quotation.item_id')
            ->where('r.id', '=', $id)
            ->groupBy('tbl_supplier_quotation.supplier_id', 's.supplier_title')
            ->get();
        // dd($query->toSql());

        return response()->json($query);
    }
    public function fetch_supplier_quotation(Request $req)
    {
        $id = $req->input('id');    
    
        $query = SupplierQuotationModel::select('a.id','s.supplier_title', 'a.item_title', 'a.app_price', 'tbl_supplier_quotation.quotation', 'tbl_supplier_quotation.winner')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->leftJoin('tbl_rfq as r', 'r.rfq_no', '=', 'tbl_supplier_quotation.rfq_no')
            ->leftJoin('tbl_app as a', 'a.id', '=', 'tbl_supplier_quotation.item_id')
            ->where('r.rfq_no', '=', $id)
            ->groupBy('a.id','s.supplier_title', 'a.item_title', 'a.app_price', 'tbl_supplier_quotation.quotation', 'tbl_supplier_quotation.winner')
            ->orderby('tbl_supplier_quotation.item_id','asc')
            ->get();
        // dd($query->toSql());

        return response()->json($query);
    }
    public function post_supplier_quote(Request $req)
    {
        $dataToSave = $req->all();

        // Process and save the data
        foreach ($dataToSave as $item) {
            // Create a new instance of SupplierQuotation model
            $supplierQuotation = new SupplierQuotationModel();

            // Assign values to model properties
            $supplierQuotation->supplier_id = $item['supplier_id'];
            $supplierQuotation->rfq_no      = $item['rfq_no'];
            $supplierQuotation->rfq_id      = $item['rfq_id'];
            $supplierQuotation->item_id     = $item['item_id'];
            $supplierQuotation->quotation   = $item['quotation'];

            // Save the model to the database
            $supplierQuotation->save();
        }

        // Respond with success message or other response
        return response()->json(['message' => 'Data saved successfully']);
    }
    public function getSmallestQuotationsForItems(Request $request)
    {
        $rfqId = $request->input('rfq_id'); // Default value of 1 if rfq_id is not provided
        $status = $request->input('status');

        $query = DB::select("
            SELECT t1.id, t1.supplier_id, t1.item_id, t1.quotation
            FROM tbl_supplier_quotation t1
            JOIN (
                SELECT item_id, MIN(quotation) AS min_quotation
                FROM tbl_supplier_quotation
                GROUP BY item_id
            ) t2 ON t1.item_id = t2.item_id AND t1.quotation = t2.min_quotation
            WHERE t1.rfq_id = :rfqId
        ", ['rfqId' => $rfqId]);

        // Define variables to store item IDs
        // Fetch the item IDs from the query results
        $itemIds = [];
        $supplierIds = [];

        foreach ($query as $row) {
            $supplierIds[] = $row->supplier_id;
            $itemIds[] = $row->id;
        }

        // Update the winner field to 1 for all items fetched by the query
        if (!empty($itemIds)) {
            SupplierQuotationModel::whereIn('id', $itemIds)
                ->where('rfq_id', $rfqId)
                ->update([
                    'winner' => 1
                ]);

                AbstractModel::where('rfq_id', $rfqId)
                ->update([
                    'supplier_id' => $supplierIds
                ]);

                PurchaseRequestModel::where('id', $request->input('pr_id'))
                ->update([
                    'stat' => $request->input('status'),
                    'id' => $request->input('pr_id'),
                ]);
        }

        return response()->json($query);
    }
}
