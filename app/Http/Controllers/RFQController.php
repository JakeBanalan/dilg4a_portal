<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RFQModel;
use App\Models\AppItemModel;
use App\Models\PurchaseRequestModel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;


class RFQController extends Controller
{
    public function generateRFQNo($cur_year = 2024)
    {
        return response()->json(
            RFQModel::select(RFQModel::raw('COUNT(*)+1 as "rfq_count" '))
                ->whereYear('rfq_date', $cur_year)
                ->get()
        );
    }
    public function fetchSubmittedPurchaseRequest()
    {
        return response()->json(
            PurchaseRequestModel::select(PurchaseRequestModel::raw('id,pr_no'))
                ->where('stat', 4)
                ->orWhere('stat', 5)
                ->orderBy('id', 'desc')

                ->get()
        );
    }
    public function fetch_rfq()
    {
        return response()->json(
            RFQModel::select(RFQModel::raw('MAX(tbl_rfq.id) AS id ,MAX(tbl_rfq.rfq_no) AS rfq_no'))
                ->leftJoin('pr', 'pr.id', '=', 'tbl_rfq.pr_id')
                ->where('pr.stat', 6)
                ->groupBy('rfq_no')
                ->get()
        );
    }
    public function post_create_rfq(Request $request)
    {
        $rfq = new RFQModel([
            'id'            => null,
            'rfq_no'         => $request->input('rfq_no'),
            'pr_id'          => $request->input('pr_id'),
            'mode_id' => $request->input('mode_id'),
            'rfq_date'  => $request->input('rfq_date'),
            'particulars'    =>  $request->input('particulars'),
            'updated_by'    =>  $request->input('updated_by'),

        ]);





        // Save the RFQ record
        $rfq->save();
        // dd($rfq);

        // Optionally, you can return a response indicating success along with the SQL query
        return response()->json(['message' => 'RFQ created successfully', 'sql_query' => $rfq], 201);
    }

    public function viewRFQItems($id, Request $request)
    {

        $query = RFQModel::select(RFQModel::raw('
        MAX(pr.id) as `pr_id`,
        MAX(tbl_rfq.id) as `rfq_id`,
        MAX(tbl_rfq.rfq_no) as `rfq_no`,
        MAX(tbl_rfq.particulars) as `particulars`,
        MAX(DATE_FORMAT(tbl_rfq.rfq_date, "%M %d, %Y")) as `rfq_date`,
        MAX(DATE_FORMAT(tbl_rfq.created_at, "%M %d, %Y")) as `received_date`,
        MAX(tbl_app.sn) as `serial_no`,
        MAX(tbl_app.item_title) as `item_title`,
        MAX(tbl_app.app_price) as `abc`,
        MAX(unit.item_unit_title) as `item_unit_title`,
        MAX(pr_items.description) as `description`,
        MAX(pr_items.qty) as `qty`,
        MAX(mode.mode_of_proc_title) AS `mode`,
        MAX(pmo.pmo_title) AS `office`,
        sum(pr_items.qty * tbl_app.app_price) as `app_price`
        '))
            ->leftJoin('pr', 'pr.id', '=', 'tbl_rfq.pr_id')
            ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('tbl_app', 'tbl_app.id', '=', 'pr_items.pr_item_id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->where('tbl_rfq.id', $id)
            ->groupBy('tbl_rfq.id');


        // Print the SQL query to check
        // dd($query->toSql());

        // Execute the query and return the result
        $app_item = $query->get();
        // print_r($app_item);

        if ($request->has('export')) {
            // Export the data to Excel
            return $this->exportToExcel($app_item);
        }

        return response()->json($app_item);
    }
    public function getPRItems($id, Request $request)
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
        '))
            ->leftJoin('pr_items', 'pr_items.pr_item_id', '=', 'tbl_app.id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('tbl_status', 'pr.stat', '=', 'tbl_status.id')
            ->where('pr.id', $id);


        $app_item = $query->get();
        return response()->json($app_item);
    }


    private function exportToExcel($data)
    {

        $data = [
            [
                'pr_id' => 1,
                'rfq_id' => 2,
                'rfq_no' => 'RFQ-2024-002',
                'mode' => 'Direct Purchase',
                'office' => 'Main Office',
                'app_price' => 100.00,
                // other fields...
            ],
            // more rows...
        ];

        // Check if data is empty
        if (empty($data)) {
            throw new \Exception("Data array is empty.");
        }

        // Define required keys
        $requiredKeys = ['pr_id', 'rfq_id', 'rfq_no', 'mode', 'office'];

        // Validate required keys
        foreach ($requiredKeys as $key) {
            if (!isset($data[0][$key])) {
                throw new \Exception("Required key '{$key}' is missing in the data array.");
            }
        }

        // Load the existing Excel template
        $templatePath = public_path('templates/rfq_template.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);

        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();

        // Initialize variables
        $row = 29; // Assuming your data starts from the second row in the template
        $pr_id = $data[0]['pr_id'];
        $rfq_id = $data[0]['rfq_id'];
        $rfq_no = $data[0]['rfq_no'];
        $mode = $data[0]['mode'];
        $office = $data[0]['office'];
        $total_amount = 0; // Initialize total amount

        // Iterate through each row of data
        foreach ($data as $rowData) {
            // Add app_price of each row to total_amount
            if (isset($rowData['app_price'])) {
                $total_amount += $rowData['app_price'];
            } else {
                throw new \Exception("Key 'app_price' is missing in the row data.");
            }
        }

        // Set values in the spreadsheet
        $sheet->setCellValueByColumnAndRow(4, 5, $mode);
        $sheet->setCellValueByColumnAndRow(10, 6, '');
        $sheet->setCellValueByColumnAndRow(4, 7, $office);
        $sheet->setCellValueByColumnAndRow(11, 5, $rfq_no);
        $sheet->setCellValueByColumnAndRow(1, 25, $total_amount);

        $query = AppItemModel::select(AppItemModel::raw('
            pr.pr_no,
            tbl_app.id as `app_id`,
            tbl_app.sn as `serial_no`,
            tbl_app.item_title as `procurement`,
            tbl_app.app_price as `app_price`,
            unit.item_unit_title as `unit`,
            pr_items.description as `description`,
            pr_items.qty as `quantity`,
            pr_items.qty * tbl_app.app_price as `total`,
            pr.purpose
        '))
            ->leftJoin('pr_items', 'pr_items.pr_item_id', '=', 'tbl_app.id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
            ->leftJoin('tbl_rfq as rfq', 'rfq.pr_id', '=', 'pr.id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('tbl_status', 'pr.stat', '=', 'tbl_status.id')
            ->where('rfq.rfq_no', $rfq_no);

        $app_data = $query->get();
        $lastRow = $row + count($app_data) + 2;

        // Concatenate PR numbers and their purposes with line breaks
        $prNumbersWithPurpose = '';
        $query = PurchaseRequestModel::select(PurchaseRequestModel::raw('
            pr.pr_no,
            pr.purpose
        '))
            ->leftJoin('tbl_rfq as rfq', 'rfq.pr_id', '=', 'pr.id')
            ->where('rfq.rfq_no', $rfq_no);
        $pr_data = $query->get();

        foreach ($pr_data as $rowData) {
            $prNumbersWithPurpose .= "REF: PR No: {$rowData->pr_no}\nPurpose: {$rowData->purpose}\n\n";
        }
        $sheet->setCellValueByColumnAndRow(2, $lastRow, $prNumbersWithPurpose);
        $sheet->mergeCells('B' . $lastRow . ':E' . $lastRow);
        $sheet->getRowDimension($lastRow)->setRowHeight(165);

        $lastRow += 2;
        $sheet->setCellValue('B' . $lastRow, 'GRAND TOTAL');
        $sheet->mergeCells('B' . $lastRow . ':K' . $lastRow);
        $sheet->getStyle('B' . $lastRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $lastRow)->getFont()->setItalic(true);
        $sheet->getStyle('B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getRowDimension($lastRow)->setRowHeight(30);

        $i = 1;
        foreach ($app_data as $rowData) {
            $sheet->setCellValueByColumnAndRow(1, $row, $i++);
            $sheet->setCellValueByColumnAndRow(2, $row, $rowData->procurement . "\n" . $rowData->description);
            $sheet->setCellValueByColumnAndRow(6, $row, $rowData->quantity);
            $sheet->setCellValueByColumnAndRow(7, $row, $rowData->unit);
            $sheet->setCellValueByColumnAndRow(8, $row, $rowData->app_price);
            $sheet->setCellValueByColumnAndRow(9, $row, $rowData->total);
            $sheet->getRowDimension($row)->setRowHeight(40);
            $sheet->mergeCells('B' . $row . ':E' . $row);

            $row++;
        }

        $sheet->getProtection()->setPassword('dilg4a@2024');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = $data[0]['rfq_no'] . '.xlsx';
        $writer->save($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
