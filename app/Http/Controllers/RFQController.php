<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RFQModel;
use App\Models\AppItemModel;
use App\Models\PurchaseRequestModel;
use App\Models\PurchaseRequestItemModel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use Carbon\Carbon;

class RFQController extends Controller
{
    public function generateRFQNo($cur_year = 2025)
    {
        return response()->json(
            RFQModel::selectRaw('COUNT(*)+1 as "rfq_count"')
                ->whereYear('rfq_date', $cur_year)
                ->get()
        );
    }

    public function fetchSubmittedPurchaseRequest()
    {
        return response()->json(
            PurchaseRequestModel::select('id', 'pr_no', 'purpose')
                ->where('stat', 10)
                ->orderBy('id', 'desc')
                ->get()
        );
    }

    public function fetch_rfq(Request $request)
    {
        $page = $request->query('page', 1); // Default page to 1 if not provided
        $itemsPerPage = $request->query('itemsPerPage', 100);

        $query = RFQModel::select(
            'tbl_rfq.id',
            'tbl_rfq.rfq_no',
            'tbl_rfq.pr_id',
            'tbl_rfq.mode_id',
            'tbl_rfq.rfq_date',
            'tbl_rfq.rfq_deadline',
            'tbl_rfq.particulars',
            'updater.last_name as updated_by',
            'creator.last_name as created_by',

        )
            ->leftJoin('users as creator', 'creator.id', '=', 'tbl_rfq.created_by')
            ->leftJoin('users as updater', 'updater.id', '=', 'tbl_rfq.updated_by');

        // Paginate the query results
        $rfqData = $query->paginate($itemsPerPage, ['*'], 'page', $page);

        // Transform the paginated collection
        $transformedCollection = $rfqData->getCollection()->map(function ($item) {
            // Ensure `pr_id` is converted into an array
            $item->pr_id = array_map('trim', explode(',', $item->pr_id ?? ''));

            // Check if there are multiple items in the `pr_id` array
            if (count($item->pr_id) > 1) {
                // Handle logic for multiple items
                $item->has_multiple_items = true;
                $item->pr_id_summary = implode(' and ', array_slice($item->pr_id, 0, 2))
                    . (count($item->pr_id) > 2 ? ', and more...' : '');
            } else {
                // Handle logic for a single item
                $item->has_multiple_items = false;
                $item->pr_id_summary = $item->pr_id[0] ?? '';
            }

            return $item;
        });

        // Replace the collection in the paginated result
        $rfqData->setCollection($transformedCollection);

        // Return the transformed paginated data as JSON
        return response()->json($rfqData);
    }

    public function fetchRFQItems($rfqID, Request $request)
    {
        $get_prID = RFQModel::select('pr_id')
            ->where('id', $rfqID)
            ->get();

        if ($get_prID->isEmpty()) {
            return response()->json(['error' => 'RFQ not found'], 404);
        }

        // Handle single or multiple `pr_id` values
        $pr_ids = $get_prID->pluck('pr_id')->toArray(); // Collect all `pr_id` values

        $allItems = []; // Initialize an array for all items

        foreach ($pr_ids as $pr_id) {
            // Split the `pr_id` string if it contains multiple IDs
            $individualPrIds = explode(',', $pr_id);

            foreach ($individualPrIds as $id) {
                $id = trim($id); // Trim whitespace

                $items = PurchaseRequestItemModel::select(
                    'pr_items.id as item_id',
                    'pr_items.pr_id',
                    'pr_items.description',
                    'pr_items.qty',
                    'pr_items.abc',
                    // 'tbl_rfq.id as RFQ_ID',
                    'pr.id as PR_ID',
                    'tbl_app.item_title',
                    'tbl_app.code',
                    // 'tbl_app.year',
                    'tbl_app.price',
                    'unit.item_unit_title as unit',
                    'unit.*',
                    // 'pmo.pmo_title',
                    DB::raw('pr_items.abc * pr_items.qty AS total_abc')
                )
                    ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
                    // ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
                    // ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
                    ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
                    ->leftJoin('tbl_app', 'tbl_app.id', '=', 'pr_items.pr_item_id')
                    ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
                    // ->leftJoin('tbl_rfq', 'tbl_rfq.pr_id', '=', 'tbl_rfq.pr_id')
                    ->where('pr_items.pr_id', $id)
                    // ->where('tbl_rfq.id', $rfqID)
                    ->get();

                if ($items->isNotEmpty()) {
                    $allItems = array_merge($allItems, $items->toArray());
                }
            }
        }

        // Return all items as a JSON response
        return response()->json($allItems);
    }


    public function fetchRFQ()
    {
        return response()->json(
            RFQModel::select(
                'pr.id AS id',
                'tbl_rfq.id AS rfq_id',
                'tbl_rfq.rfq_no AS rfq_no',
                'tbl_rfq.rfq_date AS rfq_date',
                'tbl_rfq.remarks AS remarks',
                'pr.pr_no AS pr_no',
                'pr.action_officer AS user_id',
                'users.last_name AS created_by',
                'pr.current_step AS step',
                'pmo.pmo_title AS office',
                'pr.submitted_by AS submitted_by',
                'pr.purpose AS particulars',
                'pr.pr_date AS pr_date',
                'pr.target_date AS target_date',
                'pr.is_urgent AS is_urgent',
                'pr_items.qty AS quantity',
                'pr_items.description AS desc',
                'mode_of_proc.mode_of_proc_title AS type',
                'app.sn AS serial_no',
                'app.item_title AS item_title',
                'status.title AS status',
                'status.id AS status_id',
                'Rusers.last_name AS updated_by'
                // 'pr_items.qty * app.app_price AS app_price'
            )
                ->leftJoin('pr', 'pr.id', '=', 'tbl_rfq.pr_id')
                ->leftJoin('pr_items', 'pr_items.pr_id', '=', 'pr.id')
                ->leftJoin('users', 'users.id', '=', 'pr.action_officer')
                ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
                ->leftJoin('mode_of_proc', 'mode_of_proc.id', '=', 'pr.type')
                ->leftJoin('tbl_app AS app', 'app.id', '=', 'pr_items.pr_item_id')
                ->leftJoin('tbl_status AS status', 'status.id', '=', 'pr.stat')
                ->leftJoin('users as Rusers', 'Rusers.id', '=', 'tbl_rfq.updated_by')
                ->get()
        );
    }

    public function post_create_rfq(Request $request)
    {
        $pr_id_check = $request->input('pr_id_check');
        $rfq = new RFQModel([
            'id' => null,
            'rfq_no' => $request->input('rfq_no'),
            'pr_id' => $request->input('pr_id'),
            'mode_id' => $request->input('mode_id'),
            'rfq_date' => $request->input('rfq_date'),
            'rfq_deadline' => $request->input('rfq_deadline'),
            'particulars' => $request->input('remarks'),
            'created_by' => $request->input('created_by'),
        ]);

        $rfq->save();

        foreach ($pr_id_check as $id_check) {
            PurchaseRequestModel::where('id', $id_check)
                ->update(['stat' => 11]);
        }

        return response()->json(['message' => 'RFQ created successfully', 'sql_query' => $rfq], 201);
    }

    public function viewRFQItems($id1, Request $request)
    {
        $query = RFQModel::selectRaw('
        tbl_rfq.pr_id as pr_id,
        tbl_rfq.id as rfq_id,
        tbl_rfq.rfq_no as rfq_no,
        tbl_rfq.particulars as particulars,
        tbl_rfq.rfq_date as rfq_dateTime,
        tbl_rfq.rfq_deadline as rfq_deadlineTime,
        DATE_FORMAT(tbl_rfq.rfq_date, "%M %d, %Y") as rfq_date,
        DATE_FORMAT(tbl_rfq.rfq_deadline, "%M %d, %Y") as rfq_deadline,
        DATE_FORMAT(tbl_rfq.created_at, "%M %d, %Y") as received_date,
        mode.mode_of_proc_title AS mode,
        tbl_rfq.mode_id as mode_id,
        pmo.pmo_title AS office
    ')
            ->leftJoin('pr', 'pr.id', '=', 'tbl_rfq.pr_id')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'tbl_rfq.mode_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->where('tbl_rfq.id', $id1);

        $queryResult = $query->get();

        if ($queryResult->isEmpty()) {
            return response()->json(['error' => 'RFQ not found'], 404);
        }

        // Collect `pr_id` values
        $pr_ids = $queryResult->pluck('pr_id')->toArray();

        $pmoTitles  = [];
        foreach ($pr_ids as $pr_id) {
            $individualPrIds = explode(',', $pr_id);

            foreach ($individualPrIds as $PRid) {
                $id = trim($PRid);

                $items = PurchaseRequestModel::select('pmo.pmo_title')
                    ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
                    ->where('pr.id', $id)
                    ->get();

                foreach ($items as $item) {
                    $pmoTitles[] = $item->pmo_title; // Collect all `pmo_title` values
                }
            }
        }

        $pmoTitles = array_unique($pmoTitles); // Remove duplicates
        $pmoTitleString = implode(', ', array_slice($pmoTitles, 0, -1)); // All but the last
        if (count($pmoTitles) > 1) {
            $pmoTitleString .= (empty($pmoTitleString) ? '' : ' and ') . end($pmoTitles); // Add "and" before the last item
        } else {
            $pmoTitleString = implode('', $pmoTitles); // Single title case
        }

        $result = $queryResult->toArray();
        $result[0]['offices'] = $pmoTitleString;

        // if ($request->has('export')) {
        //     return $this->exportToExcel($allItems);
        // }

        return response()->json($result);
    }

    public function PostUpdateRFQ(Request $request)
    {
        RFQModel::where('id', $request->input('id'))
            ->update([
                'particulars'       => $request->input('particulars'),
                'mode_id'       => $request->input('mode_id'),
                'rfq_date'         => $request->input('rfq_date'),
                'rfq_deadline' => $request->input('rfq_deadline'),
                'updated_by'       => $request->input('updated_by'),
            ]);
    }

    public function getPRItems($id, Request $request)
    {
        $query = AppItemModel::selectRaw('
            tbl_app.id as app_id,
            tbl_app.sn as serial_no,
            tbl_app.item_title as procurement,
            tbl_app.app_price as app_price,
            unit.item_unit_title as unit,
            pr_items.description as description,
            pr_items.qty as quantity,
            pr_items.qty * tbl_app.app_price as total,
            pr.pr_no as pr_no,
            pmo.pmo_title as office
        ')
            ->leftJoin('pr_items', 'pr_items.pr_item_id', '=', 'tbl_app.id')
            ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
            ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->leftJoin('tbl_status', 'pr.stat', '=', 'tbl_status.id')
            ->where('pr.id', $id);

        $app_item = $query->get();
        return response()->json($app_item);
    }

    public function ExportRFQ($rfqID)
    {

        //GET RFQ DETAILS
        $query = RFQModel::selectRaw('
        tbl_rfq.pr_id as pr_id,
        tbl_rfq.id as rfq_id,
        tbl_rfq.rfq_no as rfq_no,
        tbl_rfq.particulars as particulars,
        DATE_FORMAT(tbl_rfq.rfq_date, "%M %d, %Y") as rfq_date,
        DATE_FORMAT(tbl_rfq.rfq_deadline, "%M %d, %Y") as rfq_deadline,
        DATE_FORMAT(tbl_rfq.created_at, "%M %d, %Y") as received_date,
        DATE_FORMAT(tbl_rfq.rfq_deadline, "%r") as rfq_deadline_time,
        mode.mode_of_proc_title AS mode,
        pmo.pmo_title AS office
    ')
            ->leftJoin('pr', 'pr.id', '=', 'tbl_rfq.pr_id')
            // ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'tbl_rfq.mode_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->where('tbl_rfq.id', $rfqID);

        $queryResult = $query->get();

        if ($queryResult->isEmpty()) {
            return response()->json(['error' => 'RFQ not found'], 404);
        }

        // Collect `pr_id` values
        $pr_ids = $queryResult->pluck('pr_id')->toArray();

        $pmoTitles  = [];
        foreach ($pr_ids as $pr_id) {
            $individualPrIds = explode(',', $pr_id);

            foreach ($individualPrIds as $PRid) {
                $id = trim($PRid);

                $items = PurchaseRequestModel::select('pmo.pmo_title')
                    ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
                    ->where('pr.id', $id)
                    ->get();

                foreach ($items as $item) {
                    $pmoTitles[] = $item->pmo_title; // Collect all `pmo_title` values
                }
            }
        }

        $pmoTitles = array_unique($pmoTitles); // Remove duplicates
        $pmoTitleString = implode(', ', array_slice($pmoTitles, 0, -1)); // All but the last
        if (count($pmoTitles) > 1) {
            $pmoTitleString .= (empty($pmoTitleString) ? '' : ' and ') . end($pmoTitles); // Add "and" before the last item
        } else {
            $pmoTitleString = implode('', $pmoTitles); // Single title case
        }

        $result = $queryResult->toArray();
        $result[0]['offices'] = $pmoTitleString;


        /* <------------------------------------------------------------------------------------------------------------------------> */

        //GET RFQ ITEMS
        $get_prID = RFQModel::select('pr_id')
            ->where('id', $rfqID)
            ->get();

        if ($get_prID->isEmpty()) {
            return response()->json(['error' => 'RFQ not found'], 404);
        }

        // Handle single or multiple `pr_id` values
        $pr_ids = $get_prID->pluck('pr_id')->toArray(); // Collect all `pr_id` values

        $allItems = []; // Initialize an array for all items

        foreach ($pr_ids as $pr_id) {
            // Split the `pr_id` string if it contains multiple IDs
            $individualPrIds = explode(',', $pr_id);

            foreach ($individualPrIds as $id) {
                $id = trim($id); // Trim whitespace

                $items = PurchaseRequestItemModel::select(
                    'pr_items.id',
                    'pr_items.pr_id',
                    'pr_items.description',
                    'pr_items.qty',
                    'pr_items.abc',
                    'pr.id as PR_ID',
                    'tbl_app.item_title',
                    'tbl_app.code',
                    'tbl_app.price',
                    'unit.item_unit_title as unit',
                    'unit.*',
                    DB::raw('pr_items.abc * pr_items.qty AS total_abc')
                )
                    ->leftJoin('pr', 'pr.id', '=', 'pr_items.pr_id')
                    ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'pr.type')
                    ->leftJoin('tbl_app', 'tbl_app.id', '=', 'pr_items.pr_item_id')
                    ->leftJoin('item_unit as unit', 'unit.id', '=', 'tbl_app.unit_id')
                    ->where('pr_items.pr_id', $id)
                    ->get();

                if ($items->isNotEmpty()) {
                    $allItems = array_merge($allItems, $items->toArray());
                }
            }
            $totalSum = 0;
            foreach ($allItems as $item) {
                $totalSum += (float) $item['total_abc']; // Ensure total_abc is numeric
            }
        }
        /* <------------------------------------------------------------------------------------------------------------------------> */

        $templatePath = public_path('templates/rfq.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        // Set paper size to A4
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

        $row = 33;

        $sheet->getStyle('K3:P3')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF000000'],
            ],
        ]);

        $sheet->setCellValueByColumnAndRow(4, 9, $result[0]['mode']);
        $sheet->mergeCells('D9:H9');
        // $sheet->getStyle('D5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(10, 10, $result[0]['rfq_date']);
        $sheet->getStyle('J10')->applyFromArray([
            'font' => [
                'name' => 'Cambria',
                'size' => 11,
            ],
        ]);
        $sheet->setCellValueByColumnAndRow(4, 11, $result[0]['offices']);
        $sheet->setCellValueByColumnAndRow(10, 9, $result[0]['rfq_no']);
        $sheet->getStyle('J9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValueByColumnAndRow(1, 29, $totalSum);


        $rfqItemsStyle = [
            // Add key-value pairs here
            'font' => [
                'size' => 11,
                'bold' => false
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Center horizontally
                'vertical' => Alignment::VERTICAL_CENTER,   // Center vertically
            ],
        ];

        $rfqItemsStyle1 = [
            // Add key-value pairs here
            'font' => [
                'size' => 11,
                'bold' => false,
                'italic' => false
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Center horizontally
                'vertical' => Alignment::VERTICAL_CENTER,   // Center vertically
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE,
                ],

            ],
        ];

        $GTStyle = [
            'font' => [
                'name' => 'Cambria',
                'size' => 11,
                'bold' => true,
                'italic' => true
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Center horizontally
                'vertical' => Alignment::VERTICAL_CENTER,   // Center vertically
                'wrapText' => true, // Enable wrap text
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFAEAAAA'],
            ],
        ];

        $itemIndex = 1;
        foreach ($allItems as $prItems) {
            // Insert a new row before the current row
            $sheet->insertNewRowBefore($row);

            // Clear fill styles for the entire row
            $sheet->getStyle('A' . $row . ':Z' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE, // No fill color
                ],
            ]);

            // Merge specific cells in the new row
            $sheet->mergeCells('B' . $row . ':E' . $row);
            $sheet->mergeCells('K' . $row . ':M' . $row);
            $sheet->mergeCells('N' . $row . ':P' . $row);

            // Apply styles to the row
            $sheet->getStyle('B' . $row . ':E' . $row)->applyFromArray($rfqItemsStyle);
            $sheet->getStyle('F' . $row . ':P' . $row)->applyFromArray($rfqItemsStyle1);
            $sheet->getStyle('A' . $row)->applyFromArray($rfqItemsStyle1);

            // Set cell values
            $sheet->setCellValueByColumnAndRow(1, $row, $itemIndex++);
            $sheet->setCellValueByColumnAndRow(2, $row, $prItems['description']);
            $sheet->setCellValueByColumnAndRow(6, $row, $prItems['qty']);
            $sheet->setCellValueByColumnAndRow(7, $row, $prItems['unit']);
            $sheet->setCellValueByColumnAndRow(8, $row, '₱ ' . number_format($prItems['abc']));
            $sheet->setCellValueByColumnAndRow(9, $row, '₱ ' . number_format($prItems['total_abc']));


            // Adjust row height to auto-size based on the description length
            $description = $prItems['description'];
            $text_len = strlen($description);

            // Dynamically calculate row height based on the description length
            $rowHeight = 15 + (float)($text_len / 10) * 10;
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);

            // Increment row for the next iteration
            $row++;
        }

        // Insert a new row after the loop and clear inherited styles
        $sheet->insertNewRowBefore($row);

        // Clear fill styles for the entire row
        $sheet->getStyle('A' . $row . ':Z' . $row)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE, // No fill color
            ],
        ]);

        // Set values and merge cells for the final row
        $sheet->setCellValue('B' . $row, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' . "\n \n" . $result[0]['particulars']);
        $sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true);
        $sheet->mergeCells('B' . $row . ':E' . $row);
        $sheet->mergeCells('K' . $row . ':M' . $row);
        $sheet->mergeCells('N' . $row . ':P' . $row);

        // Set a custom row height for the final row
        // $sheet->getRowDimension($row)->setRowHeight(150);

        // Adjust row height to auto-size based on the description length
        $particulars = $result[0]['particulars'];
        $text_len = strlen($particulars);

        // Dynamically calculate row height based on the description length
        $rowHeight = 0 + (float)($text_len / 15) * 10;
        $sheet->getRowDimension($row)->setRowHeight($rowHeight);


        $row++;
        // $sheet->mergeCells('B' . $row . ':M' . $row);
        $sheet->setCellValue('K' . $row, 'GRAND TOTAL PER LOT:');
        $sheet->getStyle('K' . $row . ':P' . $row)->applyFromArray($GTStyle);
        $sheet->getRowDimension($row)->setRowHeight(45);


        $richText = new RichText();

        $row++;
        $sheet->getStyle('B' . $row)->applyFromArray([
            'font' => [
                'name' => 'Cambria',
                'size' => 11, // Set font size to 9
            ],
        ]);

        // Add the first part of the text
        $richText->createText('NOTE:
        *In order to be eligible for this procurement, suppliers/service providers must submit together with the quotation the following Eligibility Documents:
         1. Valid Business Permit for FY 2024
         2. Latest Income/Business Tax Return
         3. PhilGEPS Registration No. (Please indicate on the space provided above)
         4. a. Any documents to prove that the signatory of the quotation is authorized representative of the company.
          b. Photocopy of ID bearing the pictures/ signature of the representatives. 
        * Please submit your quotation using our official Request for Quotation (RFQ) Form. You can secure a copy of the 
        RFQ from the Finance and Administrative Division-General Service Section.
        Deadline:
         *Please submit your quotation together with the Eligibility Documents on or before ');

        // Add the underlined part (the $result portion)
        $underlinedText = $richText->createTextRun('_' . $result[0]['rfq_deadline'] . '_');
        $underlinedText->getFont()->setUnderline(true); // Apply underline to this part

        // Set the font size for the underlined text
        $underlinedText->getFont()->setSize(11); // Ensure same font size
        $underlinedText->getFont()->setName('Cambria');

        $addtext = $richText->createTextRun(' at ');

        $underlinedText1 = $richText->createTextRun('_' . $result[0]['rfq_deadline_time'] . '_');
        $underlinedText1->getFont()->setUnderline(true); // Apply underline to this part

        // Set the font size for the underlined text
        $underlinedText1->getFont()->setSize(11); // Ensure same font size
        $underlinedText1->getFont()->setName('Cambria');

        // Add the rest of the text (non-underlined) using createTextRun for consistent styling
        $additionalText = $richText->createTextRun(' through any of the following : 
         a. Email us at dilg4a.bac@gmail.com
         b. Deliver on hand at the receiving area of DILG IV-A CALABARZON, Andenson Bldg1. National Highway, Parian, Calamba City, Laguna');

        // Set the font size for the additional text
        $additionalText->getFont()->setSize(11); // Ensure the same font size
        $additionalText->getFont()->setName('Cambria');

        // Set the rich text content in the cell
        $sheet->setCellValue('B' . $row, $richText);

        // Set the row height
        $sheet->getRowDimension($row)->setRowHeight(415);

        $sheet->getProtection()->setPassword('dilg4a@2024');

        $writer = new Xlsx($spreadsheet);
        $fileName = $result[0]['rfq_no'] . '.xlsx';
        $writer->save($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
