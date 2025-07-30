<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Models\AbstractModel;
use App\Models\PurchaseRequestItemModel;
use App\Models\PurchaseRequestModel;
use App\Models\SupplierQuotationModel;
use App\Models\SupplierModel;
use App\Models\RFQModel;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Carbon\Carbon;

class AbstractController extends Controller
{

    const STATUS_DRAFT      = 1;
    const STATUS_RECEIVED   = 2;
    const STATUS_COMPLETED  = 3;
    const STATUS_RETURNED   = 4;

    public function PostAbstract(Request $request)
    {
        // Create and save the abstract
        $abstract = new AbstractModel([
            'abstract_no'   => $request->input('abstract_no'),
            'rfq_id'        => $request->input('rfq_id'),
            'abstract_date' => Carbon::now()
        ]);

        $abstract->save();

        // Return response with the newly generated ID
        return response()->json([
            'message'      => 'Data saved successfully',
            'abstract_id'  => $abstract->id, // Return the generated ID
            'rfq_id'  => $abstract->rfq_id // Return the generated ID
        ]);
    }
    public function viewAOQ($id)
    {
        return response()->json(
            AbstractModel::selectRaw('abstract_no,
                 DATE_FORMAT(abstract_date, "%M %d, %Y") as abstract_date,
                 DATE_FORMAT(abstract_date, "%h:%i %p") AS abstract_time'
                 )
                ->where('id', $id)
                ->get()
        );
    }
    public function generateAbstractNo($cur_year = null)
    {
        $cur_year = $cur_year ?? date('Y');

        return response()->json(
            AbstractModel::select(AbstractModel::raw('COUNT(*)+1 as "abstract" '))
                ->whereYear('created_at', $cur_year)
                ->get()
        );
    }

    public function fetch_supplier_list()
    {
        return response()->json(
            SupplierModel::selectRaw('id, supplier_title, contact_person, contact_details')
                ->get()
        );
    }

    public function PostSupplierQuotation(Request $request)
    {
        // Create and save the abstract
        $quotation = new SupplierQuotationModel([
            'abstract_id'   => $request->input('abstract_id'),
            'supplier_id'   => $request->input('supplier_id'),
            'rfq_id'        => $request->input('rfq_id'),
            'item_id'        => $request->input('item_id'),
            'offer'        => $request->input('offer'),
            'total_offer'   => $request->input('total_offer'),
            'winner'   => $request->input('winner')
        ]);

        $quotation->save();

        // Return response with the newly generated ID
        return response()->json([
            'message'      => 'Data saved successfully',
            'abstract_id'  => $quotation->id // Return the generated ID
        ]);
    }

    public function fetch_supplier_quote($id)
    {
        return response()->json(
            SupplierQuotationModel::select(
                'tbl_supplier_quotation.id',
                'tbl_supplier_quotation.abstract_id',
                'tbl_supplier_quotation.supplier_id',
                'tbl_supplier_quotation.rfq_id',
                'tbl_supplier_quotation.item_id',
                'tbl_supplier_quotation.offer',
                'tbl_supplier_quotation.total_offer',
                'tbl_supplier_quotation.winner',
                's.supplier_title'
            )
                ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
                ->where('tbl_supplier_quotation.abstract_id', $id)
                ->get()
        );
    }

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
            DB::raw('DATE_FORMAT(tbl_abstract.abstract_date, "%M %d, %Y") as abstract_date'),
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
            ->leftJoin('tbl_rfq AS r', 'r.id', '=', 'tbl_abstract.rfq_id')
            ->leftJoin('pr AS p', 'p.id', '=', 'r.pr_id')
            ->leftJoin('tbl_purchase_order as po', 'po.abstract_id', '=', 'tbl_abstract.id')
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



        // if ($req->has('export')) {
        //     // Export the data to Excel
        //     return $this->exportToExcel($data);
        // }

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
            ->orderBy('tbl_supplier_quotation.id', 'asc')
            ->get();

        $supplierQuotations = SupplierQuotationModel::select('s.id', 'p.pr_no', 'p.pr_date', 'p.purpose', 'tbl_supplier_quotation.quotation', 'tbl_supplier_quotation.winner')
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->leftJoin('tbl_rfq AS r', 'r.id', '=', 'tbl_supplier_quotation.rfq_id')
            ->leftJoin('pr AS p', 'p.id', '=', 'r.pr_id')
            ->where('tbl_supplier_quotation.rfq_id', $id)
            ->orderby('tbl_supplier_quotation.id', 'asc')
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

    public function ExportAbstract($absID)
    {

        //GET RFQ DETAILS
        $query = AbstractModel::selectRaw('
        tbl_abstract.id as abs_id,
        tbl_abstract.abstract_no as abs_no,
        DATE_FORMAT(tbl_abstract.abstract_date, "%M %d, %Y") as aoq_date,
        DATE_FORMAT(tbl_abstract.abstract_date, "%r") as aoq_time,
        tbl_rfq.pr_id AS pr_id,
        tbl_rfq.id AS rfq_id,
        tbl_rfq.rfq_no AS rfq_no,
        tbl_rfq.particulars AS particulars,
        DATE_FORMAT(tbl_rfq.rfq_date, "%M %d, %Y") AS rfq_date,
        DATE_FORMAT(tbl_rfq.rfq_deadline, "%M %d, %Y") AS rfq_deadline,
        DATE_FORMAT(tbl_rfq.created_at, "%M %d, %Y") AS received_date,
        DATE_FORMAT(tbl_rfq.rfq_deadline, "%r") AS rfq_deadline_time,
        mode.mode_of_proc_title AS mode,
        pmo.pmo_title AS office
    ')
            ->leftJoin('tbl_rfq', 'tbl_rfq.id', '=', 'tbl_abstract.rfq_id')
            ->leftJoin('pr', 'pr.id', '=', 'tbl_rfq.pr_id')
            ->leftJoin('mode_of_proc as mode', 'mode.id', '=', 'tbl_rfq.mode_id')
            ->leftJoin('pmo', 'pmo.id', '=', 'pr.pmo')
            ->where('tbl_abstract.id', $absID);

        $queryResult = $query->get();

        if ($queryResult->isEmpty()) {
            return response()->json(['error' => 'Abstract not found'], 404);
        }

        // Collect `pr_id` values
        $pr_ids = $queryResult->pluck('pr_id')->toArray();

        $prTitles  = [];
        foreach ($pr_ids as $pr_id) {
            $individualPrIds = explode(',', $pr_id);

            foreach ($individualPrIds as $PRid) {
                $id = trim($PRid);

                $items = PurchaseRequestModel::select('pr_no', 'purpose')
                    ->where('pr.id', $id)
                    ->get();

                foreach ($items as $item) {
                    $prTitles[] = $item->pr_no; // Collect all `pmo_title` values
                }
            }
        }

        // $result = $queryResult->toArray();
        // $result['prTitles'] = $prTitles;

        $prTitles = array_unique($prTitles); // Remove duplicates
        $prTitleString = implode(', ', array_slice($prTitles, 0, -1)); // All but the last
        if (count($prTitles) > 1) {
            $prTitleString .= (empty($prTitleString) ? '' : ' and ') . end($prTitles); // Add "and" before the last item
        } else {
            $prTitleString = implode('', $prTitles); // Single title case
        }

        $result = $queryResult->toArray();
        $result[0]['prTitles'] = $prTitleString;
        // return response()->json($result);

        /* <------------------------------------------------------------------------------------------------------------------------> */

        //GET RFQ ITEMS
        $get_prID = RFQModel::select('pr_id')
            ->where('id', $result[0]['rfq_id'])
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
                    'pr_items.id AS item_ID',
                    'pr_items.pr_id',
                    'pr_items.description',
                    'pr_items.qty',
                    'pr_items.abc',
                    'pr.id as PR_ID',
                    'tbl_app.item_title',
                    'tbl_app.id',
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
        // return response()->json($allItems);

        /* <------------------------------------------------------------------------------------------------------------------------> */

        $supQuery = SupplierQuotationModel::select(
            'tbl_supplier_quotation.id',
            'tbl_supplier_quotation.abstract_id',
            'tbl_supplier_quotation.supplier_id',
            'tbl_supplier_quotation.rfq_id',
            'tbl_supplier_quotation.item_id',
            'tbl_supplier_quotation.offer',
            'tbl_supplier_quotation.total_offer',
            'tbl_supplier_quotation.winner',
            's.supplier_title'
        )
            ->leftJoin('supplier as s', 's.id', '=', 'tbl_supplier_quotation.supplier_id')
            ->where('abstract_id', $absID)
            ->get();


        // return response()->json($supQuery);

        $templatePath = public_path('templates/abstract.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        // Set paper size to A4
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);


        $sheet->setCellValue('B7', 'RFQ No. ' . $result[0]['rfq_no']);
        $sheet->setCellValue('L8', $result[0]['mode']);
        $sheet->setCellValue('M9', $result[0]['abs_no']);
        $sheet->setCellValue('M10', $result[0]['aoq_date']);
        $sheet->setCellValue('M11', $result[0]['aoq_time']);

        $suppliers = $supQuery->pluck('supplier_title')->unique()->values()->toArray();


        $abstractItemsStyle = [
            // Add key-value pairs here
            'font' => [
                'size' => 12,
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

        $abstractItemsStyle1 = [
            // Add key-value pairs here
            'font' => [
                'size' => 12,
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
            ],
        ];


        // Column & row setup
        $row = 17;
        $columnIndex = 7; // Starting column index (G)
        $columnLetter = Coordinate::stringFromColumnIndex($columnIndex);
        $columnIndex = Coordinate::columnIndexFromString($columnLetter);

        // Create Supplier Offer Table Headers
        foreach ($suppliers as $supplier) {
            $column1 = Coordinate::stringFromColumnIndex($columnIndex);
            $column2 = Coordinate::stringFromColumnIndex($columnIndex + 1);

            // Merge header cells for each supplier
            $sheet->mergeCells("{$column1}13:{$column2}14");
            $sheet->setCellValue("{$column1}13", $supplier);

            $sheet->mergeCells("{$column1}15:{$column2}15");
            $sheet->setCellValue("{$column1}15", "PHP");

            // Set column headers for offers
            $sheet->setCellValue("{$column1}16", "OFFER");
            $sheet->setCellValue("{$column2}16", "TOTAL OFFER");

            // Move to the next set of columns (increment by 2)
            $columnIndex += 2;
        }

        // Insert Item Data with Offers
        foreach ($allItems as $prItem) {
            // dd($prItem);
            $sheet->insertNewRowBefore($row);

            $sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('B' . $row)->applyFromArray($abstractItemsStyle);
            $sheet->getStyle('C' . $row.':P'.$row)->applyFromArray($abstractItemsStyle1);
            $sheet->setCellValue('B' . $row, $prItem['description']);
            $sheet->setCellValue('C' . $row, $prItem['qty']);
            $sheet->setCellValue('D' . $row, $prItem['unit']);
            $sheet->setCellValue('E' . $row, '₱ ' . number_format($prItem['abc']));
            $sheet->setCellValue('F' . $row, '₱ ' . number_format($prItem['total_abc']));

            // Insert Supplier Offers
            $columnIndex = 7; // Reset to starting column (G)
            foreach ($suppliers as $supplier) {
                $column1 = Coordinate::stringFromColumnIndex($columnIndex);
                $column2 = Coordinate::stringFromColumnIndex($columnIndex + 1);

                // Fetch offer details for the specific supplier and item
                $offer = $this->getOffer($supQuery, $prItem['item_ID'], $supplier, 'offer');
                $totalOffer = $this->getOffer($supQuery, $prItem['item_ID'], $supplier, 'total_offer');

                // Populate the spreadsheet
                $sheet->setCellValue("{$column1}{$row}", is_numeric($offer) ? '₱ ' . number_format($offer) : $offer);
                $sheet->setCellValue("{$column2}{$row}", is_numeric($totalOffer) ? '₱ ' . number_format($totalOffer) : $totalOffer);

                $columnIndex += 2; // Move to next supplier columns
            }


            // Adjust row height to auto-size based on the description length
            $description = $prItem['description'];
            $text_len = strlen($description);

            // Dynamically calculate row height based on the description length
            $rowHeight = 15 + (float)($text_len / 10) * 10;
            $sheet->getRowDimension($row)->setRowHeight($rowHeight);

            $row++; // Move to next row
        }

        // $sheet->setCellValue('B20', 'PR No. ' . $result[0]['prTitles']);
        // $sheet->setCellValue('B21', 'PUR: ' . $result[0]['particulars']);
        // $sheet->getStyle('B20:B21')->getAlignment()->setWrapText(true);

        $sheet->getProtection()->setPassword('dilg4a@2024');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'text.xlsx';
        // $fileName = 'abstract-no-' . $data[0]['abstract_no'] . '.xlsx';
        $writer->save($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
    private function getOffer($quoteData, $itemId, $supplier, $field)
    {
        foreach ($quoteData as $quote) {
            // dd($quote['item_id']);
            // dd($itemId);

            if ($quote['item_id'] === $itemId && $quote['supplier_title'] === $supplier) {
                return $quote[$field] ?? 'N/A'; // Return value or 'N/A' if field doesn't exist
            }
        }
        return 'N/A';
    }
}
