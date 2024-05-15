<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Models\AbstractModel;
use App\Models\PurchaseRequestItemModel;
use App\Models\PurchaseRequestModel;
use App\Models\SupplierQuotationModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbstractController extends Controller
{
 
    const STATUS_DRAFT      = 1;
    const STATUS_RECEIVED   = 2;
    const STATUS_COMPLETED  = 3;
    const STATUS_RETURNED   = 4;
  
    public function fetch_winner_supplier($id, $sheet)
    {
        $result = SupplierQuotationModel::select('s.id', 's.supplier_title')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->where('tbl_supplier_quotation.winner', 1)
            ->where('tbl_supplier_quotation.rfq_id', $id)
            ->groupBy('s.id', 's.supplier_title')
            ->get();


        $supplierTitles = $result->pluck('supplier_title')->toArray();
        $combinedTitle = implode(' and ', $supplierTitles);
        $sheet->setCellValue('B29', 'Award is hereby recommended to be given to ' . $combinedTitle . ' which  has the lowest calculated and responsive bid');

        return $sheet;
    }

    public function generateAbstractNo($cur_year = 2024)
    {
        return response()->json(
            AbstractModel::select(AbstractModel::raw('COUNT(*)+1 as "abstract" '))
                ->whereYear('date_created', $cur_year)
                ->get()
        );
    }

    public function fetch_created_abstract(Request $req)
    {

        $id = $req->input('id');
        return response()->json(
            AbstractModel::select(
                AbstractModel::raw('
            tbl_abstract.abstract_no,
            p.pr_no,
            pmo.pmo_title as `office`,
            r.rfq_no as rfq_no
        ')
            )
                ->leftJoin('tbl_rfq as r', 'r.rfq_no', '=', 'tbl_abstract.rfq_no')
                ->leftJoin('pr as p', 'p.id', '=', 'r.pr_id')
                ->leftJoin('tbl_status as ss', 'ss.id', '=', 'p.stat')
                ->leftJoin('supplier as s', 's.id', '=', 'tbl_abstract.supplier_id')
                ->leftJoin('pmo', 'pmo.id', '=', 'p.pmo')
                ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'p.id')
                ->leftJoin('tbl_app as app', 'app.id', '=', 'pr_items.pr_item_id')
                ->where('tbl_abstract.id', $id)
                ->groupBy('tbl_abstract.abstract_no', 'p.pr_no', 'pmo.pmo_title', 'r.rfq_no')
                ->get()
        );
    }

    public function load_abstract_data(Request $request)
    {
        $page = $request->query('page');
        $itemsPerPage = $request->query('itemsPerPage', 500);
        $query = AbstractModel::select(
            'tbl_abstract.id AS id',
            DB::raw('DATE_FORMAT(tbl_abstract.date_created, "%M %d, %Y") as abstract_date'),
            DB::raw('r.id AS rfq_id'),
            DB::raw('tbl_abstract.abstract_no AS abstract_no'),
            DB::raw('r.rfq_no AS rfq_no'),
            DB::raw('DATE_FORMAT(r.rfq_date, "%M %d, %Y") as rfq_date'),
            DB::raw('DATE_FORMAT(p.pr_date, "%M %d, %Y") as pr_date'),
            DB::raw('DATE_FORMAT(po.po_date, "%M %d, %Y") as po_date'),
            DB::raw('p.pr_no AS pr_no'),
            DB::raw('po.po_no AS po_no'),
            DB::raw('po.po_amount AS po_amount'),
            DB::raw('pmo.pmo_title AS office'),
            DB::raw('s.title as status')
        )
            ->leftJoin('tbl_rfq AS r', 'r.rfq_no', '=', 'tbl_abstract.rfq_no')
            ->leftJoin('pr AS p', 'p.id', '=', 'r.pr_id')
            ->leftJoin('tbl_purchase_order as po','po.abstract_id','=','tbl_abstract.id')
            ->leftJoin('pmo', 'pmo.id', '=', 'p.pmo')
            ->leftJoin('tbl_status as s', 's.id', '=', 'p.stat')
            ->orderBy('tbl_abstract.id', 'desc');


        $data = $query->paginate($itemsPerPage, ['*'], 'page', $page);
        if ($request->has('export')) {
            // Export the data to Excel
            return $this->exportToExcel($data);
        }
        // Dump and die to output the SQL for debugging
        // dd($query->toSql());
        return response()->json($data);
    }

    public function post_create_abstract(Request $req)
    {
        $abstract = new AbstractModel([
            'abstract_no' => $req->input('abstract_no'),
            'rfq_no'      => $req->input('rfq_no'),
            'date_created'  => $req->input('date_created'),

        ]);


        $abstract->save();
        return response()->json(['message' => 'Data saved successfully']);
    }

    public function load_abstract_info($id, Request $req)
    {
        $query = AbstractModel::select(
            'tbl_abstract.id AS id',
            DB::raw('r.id AS rfq_id'),
            DB::raw('p.purpose AS particulars'),
            DB::raw('tbl_abstract.abstract_no AS abstract_no'),
            DB::raw('r.rfq_no AS rfq_no'),
            DB::raw('m.mode_of_proc_title as mode'),
            DB::raw('sum(pi.qty * a.app_price) as total_abc')
        )
            ->leftJoin('tbl_rfq AS r', 'r.rfq_no', '=', 'tbl_abstract.rfq_no')
            ->leftJoin('pr_items AS pi', 'pi.pr_id', '=', 'r.pr_id')
            ->leftJoin('tbl_app AS a', 'a.id', '=', 'pi.pr_item_id')
            ->leftJoin('mode_of_proc AS m', 'm.id', '=', 'r.mode_id')
            ->leftJoin('pr AS p', 'p.id', '=', 'r.pr_id')
            ->where('r.id', $id)
            ->groupBy('p.purpose', 'tbl_abstract.id', 'r.id', 'tbl_abstract.abstract_no', 'r.rfq_no', 'm.mode_of_proc_title')
            ->orderBy('tbl_abstract.id', 'desc');


        $data = $query->get();



        if ($req->has('export')) {
            // Export the data to Excel
            return $this->exportToExcel($data);
        }

        return response()->json($data);
    }

    public function fetch_supplier_title($id, $sheet)
    {
        $column = 'F';
        $row = 12;
        $pr_no = null;
        $pr_date = null;
        $particulars = null;
        
        $supplierTitles = SupplierQuotationModel::select('s.supplier_title')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->leftJoin('tbl_rfq as r', 'r.id', '=', 'tbl_supplier_quotation.rfq_id')
            ->where('r.id', $id)
            ->groupBy('s.supplier_title')
            ->orderBy('tbl_supplier_quotation.id','asc')
            ->get();

        $supplierQuotations = SupplierQuotationModel::select('s.id', 'p.pr_no', 'p.pr_date', 'p.purpose', 'tbl_supplier_quotation.quotation', 'tbl_supplier_quotation.winner')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->leftJoin('tbl_rfq AS r', 'r.id', '=', 'tbl_supplier_quotation.rfq_id')
            ->leftJoin('pr AS p', 'p.id', '=', 'r.pr_id')
            ->where('tbl_supplier_quotation.rfq_id', $id)
            ->orderby('tbl_supplier_quotation.id','asc')
            ->get();


        // Populate supplier titles and quotations in the Excel sheet
        foreach ($supplierTitles as $supplierTitle) {
            // Set the supplier title in the first row
            $sheet->setCellValue($column . '9', $supplierTitle['supplier_title']);
            $column++;
        }


        $supplierQuotationsArray = json_decode(json_encode($supplierQuotations), true);
        $column_mapping = [];

        foreach ($supplierQuotationsArray as $quotation) {
            $supplier_id = $quotation['id'];
            $pr_no       = $quotation['pr_no'];
            $particulars = $quotation['purpose'];
            if (!isset($column_mapping[$supplier_id])) {
                $column_mapping[$supplier_id] = chr(ord('F') + count($column_mapping));
            }
        }

        $row = 12;
        $prev_supplier_id = null;

        foreach ($supplierQuotationsArray as $quotation) {
            $supplier_id = $quotation['id'];

            if ($supplier_id !== $prev_supplier_id) {
                $row = 12;
                $prev_supplier_id = $supplier_id;
            }

            $cur_col = $column_mapping[$supplier_id];
            if ($quotation['winner'] == 1) {
                // winner is
                $sheet
                    ->getStyle($cur_col . '' . $row)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('B3E5FC');
            }
            $sheet->setCellValue($cur_col . $row, $quotation['quotation']);
            $row++;
        }


        $cur_row = $row + 1;
        $ref_row = $cur_row + 1;
        $par_row = $ref_row + 1;
        $sheet->setCellValue('B' . $cur_row, 'REF');
        $sheet->setCellValue('B' . $ref_row, 'PR No. ' . $pr_no . "\n" . 'Date Received:' . $pr_date);
        $sheet->setCellValue('B' . $par_row, 'PURPOSE: ' . $particulars);

        return $sheet;
    }

    public function setAbstractInfo($data, $sheet)
    {
        $rfq_no      = $data[0]['rfq_no'];
        $abstract_no = $data[0]['abstract_no'];
        $total_abc   = $data[0]['total_abc'];
        $mode        = $data[0]['mode'];

        $sheet->setCellValueByColumnAndRow(2, 6, 'RFQ NO.' . $rfq_no);
        $sheet->setCellValueByColumnAndRow(2, 7, "ABC:" . $total_abc);
        $sheet->setCellValueByColumnAndRow(10, 7, $mode);
        $sheet->setCellValueByColumnAndRow(10, 8, $abstract_no);
    }
    
    public function setPurchaseRequestItem($data, $sheet)
    {
        $query = PurchaseRequestItemModel::select('a.item_title', 'a.app_price', 'pr_items.qty', 'item_unit.item_unit_title')
            ->leftJoin('tbl_app as a', 'a.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit', 'item_unit.id', '=', 'a.unit_id')
            ->leftJoin('tbl_rfq as r', 'r.pr_id', '=', 'pr_items.pr_id')
            ->where('r.id', $data[0]['rfq_id'])
            ->get();
        // Start from column A
        $row = '12';

        // Iterate through data
        foreach ($query as $supplier) {
            // Set the cell value using the column index and row index
            $sheet->setCellValue('B' . $row, $supplier['item_title']);
            $sheet->setCellValue('C' . $row, $supplier['app_price']);
            $sheet->setCellValue('D' . $row, $supplier['qty']);
            $sheet->setCellValue('E' . $row, $supplier['item_unit_title']);
            $sheet->getRowDimension($row)->setRowHeight(45);


            // Increment the column counter
            $row++;
        }
        // $sheet->setCellValue('B' . $cur_row, $data[0]['particulars']);



        // Return the modified $sheet object or any other data as needed
        return $sheet;
    }

    public function exportToExcel($data)
    {
        $templatePath = public_path('templates/abstract_template.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $this->setAbstractInfo($data, $sheet); // set abstract information
        $this->setPurchaseRequestItem($data, $sheet);
        $this->fetch_supplier_title($data[0]['rfq_id'], $sheet); //PINAKA MAHIRAP
        $this->fetch_winner_supplier($data[0]['rfq_id'], $sheet);


        $sheet->getProtection()->setPassword('dilg4a@2024');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'abstract-no-' . $data[0]['abstract_no'] . '.xlsx';
        $writer->save($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }

   
}
