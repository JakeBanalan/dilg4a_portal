<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\POModel;
use App\Models\POItemsModel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use Carbon\Carbon;

class POController extends Controller
{
    public function generatePurchaseOrderNo($cur_year = null)
    {
        if ($cur_year === null) {
            $cur_year = date('Y');
        }

        return response()->json(
            POModel::select(DB::raw('COUNT(*)+1 as po_number'))
                ->whereYear('created_at', $cur_year)
                ->get()
        );
    }
    public function postPOdata(Request $request)
    {
        $grouped = collect($request->selections)->groupBy('supplier_id');

        $suffixes = range('a', 'z'); // Supports up to 26 suppliers
        $multipleSuppliers = $grouped->count() > 1;

        $suffixIndex = 0;

        foreach ($grouped as $supplierId => $items) {
            $firstItem = $items->first();

            // Add suffix if multiple suppliers exist
            $poNo = $firstItem['po_no'];
            if ($multipleSuppliers && isset($suffixes[$suffixIndex])) {
                $poNo .= $suffixes[$suffixIndex];
            }

            $po = new POModel([
                'po_no' => $poNo,
                'rfq_id' => $firstItem['rfq_id'],
                'abstract_id' => $firstItem['abstract_id'],
                'supplier_id' => $supplierId,
                'po_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $po->save();

            $poID = $po->id;

            foreach ($items as $item) {
                $poItem = new POItemsModel([
                    'po_id' => $poID,
                    'item_id' => $item['item_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $poItem->save();
            }

            $suffixIndex++;
        }
    }
}
