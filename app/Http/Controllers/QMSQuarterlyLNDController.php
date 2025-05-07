<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QOPRModel;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class QMSQuarterlyLNDController extends Controller
{
    public function generateReport($qop_id)
    {


        $fetchQOPR = QOPRModel::select(
            'tbl_qop_report.id',
            'tbl_qop_report.qop_id',
            'tbl_qop_report.date_created',
            'tbl_qop_report.created_by',
            'tbl_qop_report.status',
            'tbl_qop_report.qp_covered',
            'qop.qp_code',
            'qop.coverage',
            'qop.office',
            'qop.process_owner',
            'qop.frequency_monitoring',
            'qop.procedure_title',
            'qop.rev_no',
            'qop.EffDate',
            'qoe.id AS qoe_id',
            'qoe.objective',
            'qoe.target_percentage',
            'qoe.indicator_a',
            'qoe.indicator_b',
            'qoe.indicator_c',
            'qoe.indicator_d',
            'qoe.indicator_e',
            'qoe.formula',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS fname")
        )
            ->leftJoin('tbl_qoe AS qoe', 'qoe.qop_id', '=', 'tbl_qop_report.qop_id')
            ->leftJoin('users', 'users.id', '=', 'tbl_qop_report.created_by')
            ->leftJoin('tbl_qop AS qop', 'qop.id', '=', 'tbl_qop_report.qop_id')
            ->where('tbl_qop_report.id', $qop_id)
            ->get();

        // return response()->json($fetchQOPR);
        $obj = '';
        $n = '1';

        foreach ($fetchQOPR as $key => $dd) {
            // $obj = $qopr['objective']
            $obj .= $n++ . '. ' . $dd['objective'] . "\n";
        }
        $approver = '';
        $office = '';
        if ($fetchQOPR[0]['office'] === 'LGMED') {
            $approver = 'GILBERTO R. TUMAMAC';
            $office = 'LOCAL GOVERNMENT MONITORING AND EVALUATION DIVISION';
        } else if ($fetchQOPR[0]['office'] === 'LGCDD') {
            $approver = 'ROBINSON MAAC';
            $office = 'LOCAL GOVERNMENT CAPACITY DEVELOPMENT DIVISION';
        } else if ($fetchQOPR[0]['office'] === 'FAD') {
            $approver = 'CARINA S. CRUZ';
            $office = 'FINANCE AND ADMINISTRATIVE DIVISION';
        } else if ($fetchQOPR[0]['office'] === 'FAD-HRS') {
            $approver = 'CARINA S. CRUZ';
            $office = 'FINANCE AND ADMINISTRATIVE DIVISION - HUMAN RESOURCE SECTION';
        } else if ($fetchQOPR[0]['office'] === 'FAD-ACCOUNTING') {
            $approver = 'CARINA S. CRUZ';
            $office = 'FINANCE AND ADMINISTRATIVE DIVISION - ACCOUNTING SECTION';
        } else if ($fetchQOPR[0]['office'] === 'FAD-RECORDS') {
            $approver = 'CARINA S. CRUZ';
            $office = 'FINANCE AND ADMINISTRATIVE DIVISION - RECORDS SECTION';
        } else if ($fetchQOPR[0]['office'] === 'FAD-GSS') {
            $approver = 'CARINA S. CRUZ';
            $office = 'FINANCE AND ADMINISTRATIVE DIVISION - GENERAL SERVICE SECTION';
        } else if ($fetchQOPR[0]['office'] === 'ORD') {
            $office = 'Office of The Regional Director';
        } else if ($fetchQOPR[0]['office'] === 'ORD-Legal') {
            $office = 'OFFICE OF THE REGIONAL DIRECTOR - LEGAL UNIT';
        } else if ($fetchQOPR[0]['office'] === 'ORD-Planning') {
            $office = 'OFFICE OF THE REGIONAL DIRECTOR - PLANNING UNIT';
        } else if ($fetchQOPR[0]['office'] === 'ORD - RICTU') {
            $office = 'OFFICE OF THE REGIONAL DIRECTOR - REGIONAL INFORMATION AND COMMUNICATION TECHNOLOGY UNIT';
        }

        // return response()->json($obj);
        $templatePath = public_path('templates/qms_qme_report_template.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
        $alignmentStyleArray = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $style3 = [
            'fill' => [
                'type' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'E7E6E6'],
            ],
            'borders' => [
                'left' => [
                    'style' => Border::BORDER_THIN,
                ],
                'right' => [
                    'style' => Border::BORDER_THIN,
                ],
            ],
        ];

        $style2 = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            // Uncomment and adjust the fill part if needed
            // 'fill' => [
            //     'fillType' => Fill::FILL_SOLID,
            //     'startColor' => ['rgb' => 'E7E6E6'],
            // ],
        ];

        $style1 = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            // 'fill' => [
            //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
            //     'color' => ['rgb' => 'E7E6E6']
            // ],
        ];

        $headerStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'E7E6E6'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->getStyle('U1:X1')->applyFromArray([
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font'  => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 8,
                'name'  => 'Cambria',
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '000000'], // Remove the '#' symbol for color codes
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],
        ]);

        $sheet->mergeCells('A15:M16');
        // $sheet->mergeCells('D16:I16');
        // $sheet->mergeCells('A16:X16');
        $sheet->mergeCells('V15:X16');
        $sheet->mergeCells('W3:X3');
        $sheet->mergeCells('W4:X4');
        $sheet->mergeCells('N15:U16');
        $sheet->getStyle('A16:X16')->applyFromArray($styleArray);
        $sheet->getStyle('I16:X16')->applyFromArray($alignmentStyleArray);

        $sheet->getCell('U1')->setValue('Document Code');
        $sheet->setCellValue('U2', $fetchQOPR[0]['qp_code']);
        $sheet->setCellValue('U4', $fetchQOPR[0]['rev_no']);
        $sheet->setCellValue('V4', $fetchQOPR[0]['EffDate']);
        $sheet->setCellValue('I6', $office);
        $sheet->setCellValue('I8', $fetchQOPR[0]['procedure_title']);
        $sheet->setCellValue('I10', $obj);
        $sheet->setCellValue('I13', $fetchQOPR[0]['qp_covered']);

        $sheet->getCell('A15')->setValue(' INDICATORS');
        $sheet->getCell('N15')->setValue('YEAR');
        $sheet->getCell('V15')->setValue('REMARKS');

        $sheet->getStyle('A15:X16')->getFont('Cambria')->setBold(true);
        $sheet->getStyle('A15:X16')->applyFromArray($headerStyle);

        $a = '';
        $row = 17;
        $counter = '';
        $initial_count = 0;
        foreach ($fetchQOPR as $key => $entry) {
            // $counter = $entry['objective'];
            $entry_id = $entry['id'];
            $id = $entry['qoe_id'];
            $qmes = DB::table('tbl_qoe_frequency_entry as a')
                ->join('tbl_qms_gap_analysis as b', 'a.qop_entry_id', '=', 'b.qop_entry_id')
                ->where('a.qop_entry_id', $entry_id)
                ->where('a.qoe_id', $id)
                ->where('b.qoe_id', $id)
                ->select(
                    'a.id',
                    'a.qop_entry_id',
                    'a.qoe_id',
                    'a.rate',
                    'a.indicator',
                    'b.qop_entry_id as b_qop_entry_id',
                    'b.qoe_id as b_qoe_id',
                    'b.is_gap_analysis',
                    'b.gap_analysis',
                )
                ->get();
            // return response()->json($qmes);

            // Map over the result to transform the data
            $qmes = $qmes->map(function ($row) {
                $rate = (array) json_decode($row->rate);

                return [
                    'id'            => $row->id,
                    'qop_entry_id'  => $row->qop_entry_id,
                    'qoe_id'        => $row->qoe_id,
                    'rate'          => $rate,
                    'total'         => '',
                    'indicator'     => $row->indicator,
                    'is_gap_analysis' => $row->is_gap_analysis,
                    'gap_analysis'  => $row->gap_analysis
                ];
            })->toArray();
            // return response()->json($qmes);


            $sheet->getRowDimension($row)->setRowHeight('30');
            $indicator = 'Objective ' . ++$counter . ': ' . $entry['objective'];
            $sheet->getCell('A' . $row)->setValue($indicator);
            $sheet->getStyle("A" . $row . ':X' . $row)->applyFromArray($style2);
            // $sheet->getStyle("A".$row)->applyFromArray($style3);
            // $sheet->getStyle("X".$row)->applyFromArray($style3);
            $sheet->mergeCells('A' . $row . ':X' . $row++);

            $sheet->getRowDimension($row)->setRowHeight('40');
            $sheet->getCell('A' . $row)->setValue('A');
            $sheet->getCell('C' . $row)->setValue($entry['indicator_a']);
            $sheet->getCell('J' . $row)->setValue('Target Result: ' . $entry['target_percentage']);

            $sheet->getCell('N' . $row)->setValue(!empty($qmes) && isset($qmes[0]['rate']['Q1']) ? $qmes[0]['rate']['Q1'] : '');
            $sheet->getCell('V' . $row)->setValue(!empty($qmes) && isset($qmes[0]['rate']['Q2']) ? $qmes[0]['rate']['Q2'] : '');
            $sheet->getRowDimension($row)->setRowHeight('30');

            $sheet->getRowDimension($row)->setRowHeight('30');
            $sheet->getStyle("A" . $row . ':B' . $row)->applyFromArray($style1);
            $sheet->getStyle("K" . $row . ':X' . $row)->applyFromArray($style1);
            $sheet->getStyle("A" . $row . ':B' . $row)->getAlignment()->setWrapText(true);

            $sheet->getStyle("C" . $row . ':I' . $row)->applyFromArray($style2);
            $sheet->getStyle("C" . $row . ':I' . $row)->getAlignment()->setWrapText(true);

            $sheet->getStyle("J" . $row . ':M' . $row)->applyFromArray($style2);
            $sheet->getStyle("J" . $row . ':M' . $row)->getAlignment()->setWrapText(true);

            $sheet->mergeCells('A' . $row . ':B' . $row);
            $sheet->mergeCells('C' . $row . ':I' . $row);
            $sheet->mergeCells('J' . $row . ':M' . $row);
            $sheet->mergeCells('N' . $row . ':U' . $row);
            $sheet->mergeCells('V' . $row . ':X' . $row++);
            //FORMULA
            //GAP ANALYSIS
            // $qmes = $qms->fetchQOEFrequency($entry_id, $entry['qoe_id']);
            $sheet->getCell('A' . $row)->setValue('B');
            $sheet->getCell('C' . $row)->setValue('Gap Analysis: In case the objective is not met, put your analysis why it is not met.');

            $sheet->getRowDimension($row)->setRowHeight('30');

            $sheet->getStyle("A" . $row . ':B' . $row)->applyFromArray($style1);
            $sheet->getStyle("N" . $row . ':X' . $row)->applyFromArray($style1);
            $sheet->getStyle("C" . $row . ':M' . $row)->applyFromArray($style2);
            $sheet->getStyle("C" . $row . ':M' . $row)->getAlignment()->setWrapText(true);
            $sheet->mergeCells('A' . $row . ':B' . $row);
            $sheet->mergeCells('C' . $row . ':M' . $row);
            $sheet->getCell('N' . $row)->setValue($qmes[0]['gap_analysis'])->getStyle('J' . $row)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->mergeCells('N' . $row . ':X' . $row++);

            // $sheet->getStyle("A".$row.':X'.$row)->applyFromArray($style4);
            // // $sheet->mergeCells('A'.$row.':X'.$row);
            $sheet->getRowDimension($row)->setRowHeight('8.4');
            $a++;
            if ($a == 1) {
                break;
            }
        }
        $qoe = $fetchQOPR->toArray();
        $qoekey = array_slice($qoe, 1);
        // return response()->json($qoe);

        foreach ($qoekey as $key => $entry) {
            $entry_id = $entry['id'];
            $id = $entry['qoe_id'];
            $qmes = DB::table('tbl_qoe_frequency_entry as a')
                ->join('tbl_qms_gap_analysis as b', 'a.qop_entry_id', '=', 'b.qop_entry_id')
                ->where('a.qop_entry_id', $entry_id)
                ->where('a.qoe_id', $id)
                ->where('b.qoe_id', $id)
                ->select(
                    'a.id',
                    'a.qop_entry_id',
                    'a.qoe_id',
                    'a.rate',
                    'a.indicator',
                    'b.qop_entry_id as b_qop_entry_id',
                    'b.qoe_id as b_qoe_id',
                    'b.is_gap_analysis',
                    'b.gap_analysis',
                )
                ->get();
            // return response()->json($qmes);

            // Map over the result to transform the data
            $qmes = $qmes->map(function ($row) {
                $rate = (array) json_decode($row->rate);

                return [
                    'id'            => $row->id,
                    'qop_entry_id'  => $row->qop_entry_id,
                    'qoe_id'        => $row->qoe_id,
                    'rate'          => $rate,
                    'total'         => '',
                    'indicator'     => $row->indicator,
                    'is_gap_analysis' => $row->is_gap_analysis,
                    'gap_analysis'  => $row->gap_analysis
                ];
            })->toArray();
            $sheet->getRowDimension($row)->setRowHeight('30');
            $sheet->getCell('A' . $row)->setValue(' INDICATORS');
            $sheet->getCell('N' . $row)->setValue('1ST QUARTER');
            $sheet->getCell('P' . $row)->setValue('2ND QUARTER');
            $sheet->getCell('R' . $row)->setValue('3RD QUARTER');
            $sheet->getCell('T' . $row)->setValue('4TH QUARTER');
            $sheet->getCell('V' . $row)->setValue('TOTAL');
            $sheet->getStyle('A' . $row . ':X' . $row)->getFont('Cambria')->setBold(true);
            $sheet->mergeCells('A' . $row . ':M' . $row);
            $sheet->mergeCells('V' . $row . ':X' . $row);
            $sheet->mergeCells('N' . $row . ':O' . $row);
            $sheet->mergeCells('P' . $row . ':Q' . $row);
            $sheet->mergeCells('R' . $row . ':S' . $row);
            $sheet->mergeCells('T' . $row . ':U' . $row);
            $sheet->getStyle('A' . $row . ':X' . $row)->applyFromArray($headerStyle);

            $sheet->getStyle("A" . $row . ':B' . $row)->applyFromArray($style1);
            $sheet->getStyle("K" . $row . ':X' . $row)->applyFromArray($style1);
            $sheet->getStyle("A" . $row . ':B' . $row)->getAlignment()->setWrapText(true);

            $sheet->mergeCells('A' . $row . ':B' . $row);
            $sheet->mergeCells('N' . $row . ':O' . $row);
            $sheet->mergeCells('P' . $row . ':Q' . $row);
            $sheet->mergeCells('R' . $row . ':S' . $row);
            $sheet->mergeCells('T' . $row . ':U' . $row);
            $sheet->mergeCells('C' . $row . ':M' . $row);
            $sheet->mergeCells('V' . $row . ':X' . $row);

            $row = $row + 1;

            $sheet->getRowDimension($row)->setRowHeight('30');
            $indicator = 'Objective ' . ++$counter . ': ' . $entry['objective'];
            $sheet->getCell('A' . $row)->setValue($indicator);
            $sheet->getStyle("A" . $row . ':X' . $row)->applyFromArray($style2);
            // $sheet->getStyle("A".$row)->applyFromArray($style3);
            // $sheet->getStyle("X".$row)->applyFromArray($style3);
            $sheet->mergeCells('A' . $row . ':X' . $row++);

            $formula = '';
            $gap_analysis = '';
            if ($entry['indicator_a'] != '') {
                $sheet->getCell('A' . $row)->setValue('A');
                $sheet->getCell('D' . $row)->setValue($entry['indicator_a']);
                $formula = 'B';
                $gap_analysis = 'C';
                // === CONVERT THIS TO DYNAMIC
                // === DATA TO BE DISPLAY WILL DEPEND ON CURRENT PERIOD 
                for ($i = 1; $i < 5; $i++) {
                    $sheet->getCell('J' . $row)->setValue(!empty($qmes) && isset($qmes[0]['rate']['Q1']) ? $qmes[0]['rate']['Q1'] : '');
                    $sheet->getCell('M' . $row)->setValue(!empty($qmes) && isset($qmes[0]['rate']['Q2']) ? $qmes[0]['rate']['Q2'] : '');
                    $sheet->getCell('P' . $row)->setValue(!empty($qmes) && isset($qmes[0]['rate']['Q3']) ? $qmes[0]['rate']['Q3'] : '');
                    $sheet->getCell('S' . $row)->setValue(!empty($qmes) && isset($qmes[0]['rate']['Q4']) ? $qmes[0]['rate']['Q4'] : '');
                }
                // ====
                $indATotal = $qmes[0]['rate']['Q1'] + $qmes[0]['rate']['Q2'] + $qmes[0]['rate']['Q3'] + $qmes[0]['rate']['Q4'];
                $sheet->getCell('V' . $row)->setValue(!empty($qmes) ? ($indATotal > 0 ? $indATotal : '0') : '0');

                // AUTO ROW HEIGHT NOT WORKING DUE TO VERSION CONFLICT
                $sheet->getRowDimension($row)->setRowHeight('45');
                $char_len = strlen($entry['indicator_a']);
                if ($char_len > 100) {
                    $sheet->getRowDimension($row)->setRowHeight('70');
                } else if ($char_len > 150) {
                    $sheet->getRowDimension($row)->setRowHeight('110');
                }

                $sheet->getStyle("A" . $row . ':C' . $row)->applyFromArray($style1);
                $sheet->getStyle("J" . $row . ':X' . $row)->applyFromArray($style1);
                // $sheet->getStyle("A".$row)->applyFromArray($style3);
                // $sheet->getStyle("X".$row)->applyFromArray($style3);
                $sheet->getStyle("A" . $row . ':C' . $row)->getAlignment()->setWrapText(true);

                $sheet->getStyle("D" . $row . ':I' . $row)->applyFromArray($style2);
                $sheet->getStyle("D" . $row . ':I' . $row)->getAlignment()->setWrapText(true);

                $sheet->mergeCells('A' . $row . ':C' . $row);
                $sheet->mergeCells('D' . $row . ':I' . $row);
                $sheet->mergeCells('J' . $row . ':L' . $row);
                $sheet->mergeCells('M' . $row . ':O' . $row);
                $sheet->mergeCells('P' . $row . ':R' . $row);
                $sheet->mergeCells('S' . $row . ':U' . $row);
                $sheet->mergeCells('V' . $row . ':X' . $row++);
            }


            if ($entry['indicator_b'] != '') {
                $sheet->getCell('A' . $row)->setValue('B');
                $sheet->getCell('D' . $row)->setValue($entry['indicator_b']);
                $formula = 'C';
                $gap_analysis = 'D';

                // === CONVERT THIS TO DYNAMIC
                // === DATA TO BE DISPLAY WILL DEPEND ON CURRENT PERIOD 
                for ($i = 1; $i < 13; $i++) {
                    $sheet->getCell('J' . $row)->setValue(!empty($qmes) && isset($qmes[1]['rate']['Q1']) ? $qmes[1]['rate']['Q1'] : '');
                    $sheet->getCell('M' . $row)->setValue(!empty($qmes) && isset($qmes[1]['rate']['Q2']) ? $qmes[1]['rate']['Q2'] : '');
                    $sheet->getCell('P' . $row)->setValue(!empty($qmes) && isset($qmes[1]['rate']['Q3']) ? $qmes[1]['rate']['Q3'] : '');
                    $sheet->getCell('S' . $row)->setValue(!empty($qmes) && isset($qmes[1]['rate']['Q4']) ? $qmes[1]['rate']['Q4'] : '');
                }
                // ===
                $indBTotal = $qmes[1]['rate']['Q1'] + $qmes[1]['rate']['Q2'] + $qmes[1]['rate']['Q3'] + $qmes[1]['rate']['Q4'];
                $sheet->getCell('V' . $row)->setValue(!empty($qmes) ? ($indBTotal > 0 ? $indBTotal : '0') : '0');

                $sheet->getRowDimension($row)->setRowHeight('45');
                $char_len = strlen($entry['indicator_a']);
                if ($char_len > 100) {
                    $sheet->getRowDimension($row)->setRowHeight('70');
                } else if ($char_len > 150) {
                    $sheet->getRowDimension($row)->setRowHeight('110');
                }

                $sheet->getStyle("A" . $row . ':C' . $row)->applyFromArray($style1);
                $sheet->getStyle("J" . $row . ':X' . $row)->applyFromArray($style1);
                // $sheet->getStyle("A".$row)->applyFromArray($style3);
                // $sheet->getStyle("X".$row)->applyFromArray($style3);
                $sheet->getStyle("A" . $row . ':C' . $row)->getAlignment()->setWrapText(true);

                $sheet->getStyle("D" . $row . ':I' . $row)->applyFromArray($style2);
                $sheet->getStyle("D" . $row . ':I' . $row)->getAlignment()->setWrapText(true);

                $sheet->mergeCells('A' . $row . ':C' . $row);
                $sheet->mergeCells('D' . $row . ':I' . $row);
                $sheet->mergeCells('J' . $row . ':L' . $row);
                $sheet->mergeCells('M' . $row . ':O' . $row);
                $sheet->mergeCells('P' . $row . ':R' . $row);
                $sheet->mergeCells('S' . $row . ':U' . $row);
                $sheet->mergeCells('V' . $row . ':X' . $row++);
            }


            if ($entry['indicator_c'] != '') {
                $sheet->getCell('A' . $row)->setValue('C');
                $sheet->getCell('D' . $row)->setValue($entry['indicator_c']);
                $formula = 'D';
                $gap_analysis = 'E';

                // === CONVERT THIS TO DYNAMIC
                // === DATA TO BE DISPLAY WILL DEPEND ON CURRENT PERIOD 
                for ($i = 1; $i < 5; $i++) {
                    $sheet->getCell('J' . $row)->setValue(!empty($qmes) && isset($qmes[2]['rate']['Q1']) ? $qmes[2]['rate']['Q1'] : '');
                    $sheet->getCell('M' . $row)->setValue(!empty($qmes) && isset($qmes[2]['rate']['Q2']) ? $qmes[2]['rate']['Q2'] : '');
                    $sheet->getCell('P' . $row)->setValue(!empty($qmes) && isset($qmes[2]['rate']['Q3']) ? $qmes[2]['rate']['Q3'] : '');
                    $sheet->getCell('S' . $row)->setValue(!empty($qmes) && isset($qmes[2]['rate']['Q4']) ? $qmes[2]['rate']['Q4'] : '');
                }
                // ====
                $indCTotal = $qmes[2]['rate']['Q1'] + $qmes[2]['rate']['Q2'] + $qmes[2]['rate']['Q3'] + $qmes[2]['rate']['Q4'];
                $sheet->getCell('V' . $row)->setValue(!empty($qmes) ? ($indCTotal > 0 ? $indCTotal : '0') : '0');

                // AUTO ROW HEIGHT NOT WORKING DUE TO VERSION CONFLICT
                $sheet->getRowDimension($row)->setRowHeight('45');
                $char_len = strlen($entry['indicator_a']);
                if ($char_len > 100) {
                    $sheet->getRowDimension($row)->setRowHeight('70');
                } else if ($char_len > 150) {
                    $sheet->getRowDimension($row)->setRowHeight('110');
                }

                $sheet->getStyle("A" . $row . ':C' . $row)->applyFromArray($style1);
                $sheet->getStyle("J" . $row . ':X' . $row)->applyFromArray($style1);
                // $sheet->getStyle("A".$row)->applyFromArray($style3);
                // $sheet->getStyle("X".$row)->applyFromArray($style3);
                $sheet->getStyle("A" . $row . ':C' . $row)->getAlignment()->setWrapText(true);

                $sheet->getStyle("D" . $row . ':I' . $row)->applyFromArray($style2);
                $sheet->getStyle("D" . $row . ':I' . $row)->getAlignment()->setWrapText(true);

                $sheet->mergeCells('A' . $row . ':C' . $row);
                $sheet->mergeCells('D' . $row . ':I' . $row);
                $sheet->mergeCells('J' . $row . ':L' . $row);
                $sheet->mergeCells('M' . $row . ':O' . $row);
                $sheet->mergeCells('P' . $row . ':R' . $row);
                $sheet->mergeCells('S' . $row . ':U' . $row);
                $sheet->mergeCells('V' . $row . ':X' . $row++);
            }


            if ($entry['indicator_d'] != '') {
                $sheet->getCell('A' . $row)->setValue('D');
                $sheet->getCell('D' . $row)->setValue($entry['indicator_d']);
                $formula = 'E';
                $gap_analysis = 'F';

                // === CONVERT THIS TO DYNAMIC
                // === DATA TO BE DISPLAY WILL DEPEND ON CURRENT PERIOD 
                for ($i = 1; $i < 5; $i++) {
                    $sheet->getCell('J' . $row)->setValue(!empty($qmes) && isset($qmes[3]['rate']['Q1']) ? $qmes[3]['rate']['Q1'] : '');
                    $sheet->getCell('M' . $row)->setValue(!empty($qmes) && isset($qmes[3]['rate']['Q2']) ? $qmes[3]['rate']['Q2'] : '');
                    $sheet->getCell('P' . $row)->setValue(!empty($qmes) && isset($qmes[3]['rate']['Q3']) ? $qmes[3]['rate']['Q3'] : '');
                    $sheet->getCell('S' . $row)->setValue(!empty($qmes) && isset($qmes[3]['rate']['Q4']) ? $qmes[3]['rate']['Q4'] : '');
                }
                // ====
                $indDTotal = $qmes[3]['rate']['Q1'] + $qmes[3]['rate']['Q2'] + $qmes[3]['rate']['Q3'] + $qmes[3]['rate']['Q4'];
                $sheet->getCell('V' . $row)->setValue(!empty($qmes) ? ($indDTotal > 0 ? $indDTotal : '0') : '0');

                // AUTO ROW HEIGHT NOT WORKING DUE TO VERSION CONFLICT
                $sheet->getRowDimension($row)->setRowHeight('45');
                $char_len = strlen($entry['indicator_a']);
                if ($char_len > 100) {
                    $sheet->getRowDimension($row)->setRowHeight('70');
                } else if ($char_len > 150) {
                    $sheet->getRowDimension($row)->setRowHeight('110');
                }

                $sheet->getStyle("A" . $row . ':C' . $row)->applyFromArray($style1);
                $sheet->getStyle("J" . $row . ':X' . $row)->applyFromArray($style1);
                // $sheet->getStyle("A".$row)->applyFromArray($style3);
                // $sheet->getStyle("X".$row)->applyFromArray($style3);
                $sheet->getStyle("A" . $row . ':C' . $row)->getAlignment()->setWrapText(true);

                $sheet->getStyle("D" . $row . ':I' . $row)->applyFromArray($style2);
                $sheet->getStyle("D" . $row . ':I' . $row)->getAlignment()->setWrapText(true);

                $sheet->mergeCells('A' . $row . ':C' . $row);
                $sheet->mergeCells('D' . $row . ':I' . $row);
                $sheet->mergeCells('J' . $row . ':L' . $row);
                $sheet->mergeCells('M' . $row . ':O' . $row);
                $sheet->mergeCells('P' . $row . ':R' . $row);
                $sheet->mergeCells('S' . $row . ':U' . $row);
                $sheet->mergeCells('V' . $row . ':X' . $row++);
            }


            // FORMULA---------------------

            $sheet->getCell('A' . $row)->setValue($formula);
            $sheet->getCell('D' . $row)->setValue('Formula: ' . $entry['formula']);
            $sheet->getCell('H' . $row)->setValue('Target: ' . $entry['target_percentage']);

            // === CONVERT THIS TO DYNAMIC
            // === DATA TO BE DISPLAY WILL DEPEND ON CURRENT PERIOD 
            for ($i = 1; $i < 5; $i++) {
                $sheet->getCell('J' . $row)->setValue(!empty($qmes) && isset($qmes[4]['rate']['Q1']) ? $qmes[4]['rate']['Q1'] : 'n/a');
                $sheet->getCell('M' . $row)->setValue(!empty($qmes) && isset($qmes[4]['rate']['Q2']) ? $qmes[4]['rate']['Q2'] : 'n/a');
                $sheet->getCell('P' . $row)->setValue(!empty($qmes) && isset($qmes[4]['rate']['Q3']) ? $qmes[4]['rate']['Q3'] : 'n/a');
                $sheet->getCell('S' . $row)->setValue(!empty($qmes) && isset($qmes[4]['rate']['Q4']) ? $qmes[4]['rate']['Q4'] : 'n/a');
            }
            // ===
            // $divider = count($qmes[4]['rate']) / 2;
            // $divider = $qmes[4]['total'][0];
            // print_r($qmes[4]['total'][0]);
            // print_r($qmes[4]['rate']);
            // print_r($qmes[1]['total']);
            // $div = (int)((int)$qmes[0]['total'] + (int)$qmes[1]['total']);

            $A = isset($indATotal) ? $indATotal : null;
            $B = isset($indBTotal) ? $indBTotal : null;
            $C = isset($indCTotal) ? $indCTotal : null;
            $D = isset($indDTotal) ? $indDTotal : null;

            if ($entry['formula'] == 'A/Bx100') {
                if ($B != 0 && $B !== null) {
                    $result = ($A / $B) * 100;
                    $div = ($result == 100 || $result == 0) ? intval($result) . '%' : number_format($result, 2) . '%';
                } else {
                    $div = 'N/A';
                }
                $sheet->getCell('V' . $row)->setValue($div);
            
            } else if ($entry['formula'] == 'No. of Days Elapsed B-A') {
                $sheet->getCell('V' . $row)->setValue('N/A');
            
            } else if ($entry['formula'] == 'Notice of Suspension/Disallowance') {
                $sheet->getCell('V' . $row)->setValue('N/A');
            
            } else if ($entry['formula'] == 'A/(B+C)-Dx100') {
                $denominator = ($B + $C - $D);
                if ($denominator != 0 && $denominator !== null) {
                    $result = ($A / $denominator) * 100;
                    $div = ($result == 100 || $result == 0) ? intval($result) . '%' : number_format($result, 2) . '%';
                } else {
                    $div = 'N/A';
                }
                $sheet->getCell('V' . $row)->setValue($div);
            }

            // if($entry['formula'] == 'A/Bx100'){
            //     $div = round($A / $B * 100) . '%';
            //     $sheet->getCell('V'.$row)->setValue($div);
            //     // print_r($div);
            //     }else if ($entry['formula'] == 'No. of Days Elapsed B-A'){
            //     // $div = (int)(int)($qmes[1]['total'] - (int)$qmes[0]['total']);
            //     $sheet->getCell('V'.$row)->setValue('');
            //     }else if($entry['formula'] == 'Notice of Suspension/Disallowance'){
            //     // $div = '3';
            //     //no indicator
            //     $sheet->getCell('V'.$row)->setValue('');
            //     }else if($entry['formula'] == 'A/(B+C)-Dx100'){
            //     $div = round($A / ($B + $C) - $D * 100) . '%';
            //     $sheet->getCell('V'.$row)->setValue($div);
            //     }


            // $sheet->getCell('V'.$row)->setValue(!empty($qmes) ? ($qmes[4]['total'] > 0 ? $div.'%' : '') : '');
            // $sheet->getCell('V'.$row)->setValue($div.'%');

            // AUTO ROW HEIGHT NOT WORKING DUE TO VERSION CONFLICT
            $sheet->getRowDimension($row)->setRowHeight('45');
            $char_len = strlen($entry['indicator_e']);
            if ($char_len > 100) {
                $sheet->getRowDimension($row)->setRowHeight('70');
            } else if ($char_len > 150) {
                $sheet->getRowDimension($row)->setRowHeight('110');
            }
            $sheet->getStyle("A" . $row . ':C' . $row)->applyFromArray($style1);
            $sheet->getStyle("J" . $row . ':X' . $row)->applyFromArray($style1);
            // $sheet->getStyle("A".$row)->applyFromArray($style3);
            // $sheet->getStyle("X".$row)->applyFromArray($style3);
            $sheet->getStyle("A" . $row . ':C' . $row)->getAlignment()->setWrapText(true);

            $sheet->getStyle("D" . $row . ':I' . $row)->applyFromArray($style2);
            $sheet->getStyle("D" . $row . ':I' . $row)->getAlignment()->setWrapText(true);

            $sheet->mergeCells('A' . $row . ':C' . $row);
            $sheet->mergeCells('D' . $row . ':G' . $row);
            $sheet->mergeCells('H' . $row . ':I' . $row);
            $sheet->mergeCells('J' . $row . ':L' . $row);
            $sheet->mergeCells('M' . $row . ':O' . $row);
            $sheet->mergeCells('P' . $row . ':R' . $row);
            $sheet->mergeCells('S' . $row . ':U' . $row);
            $sheet->mergeCells('V' . $row . ':X' . $row++);
            // //FORMULA



            $sheet->getCell('A' . $row)->setValue($gap_analysis);
            $sheet->getCell('D' . $row)->setValue('Gap Analysis: In case the objective is not met, put your analysis why it is not met.');

            $sheet->getRowDimension($row)->setRowHeight('30');

            $sheet->getStyle("A" . $row . ':C' . $row)->applyFromArray($style1);
            $sheet->getStyle("J" . $row . ':X' . $row)->applyFromArray($style1);
            $sheet->getStyle("D" . $row . ':I' . $row)->applyFromArray($style2);
            // $sheet->getStyle("A".$row)->applyFromArray($style3);
            // $sheet->getStyle("X".$row)->applyFromArray($style3);
            $sheet->getStyle("D" . $row . ':I' . $row)->getAlignment()->setWrapText(true);
            $sheet->mergeCells('A' . $row . ':C' . $row);
            $sheet->mergeCells('D' . $row . ':I' . $row);
            $sheet->getCell('J' . $row)->setValue($qmes[1]['gap_analysis'])->getStyle('J' . $row)->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->mergeCells('J' . $row . ':X' . $row++);
        }

        // return response()->json($fetchQOPR);


        $row = $row + 3;


        $style5 = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'font'  => [
                'color' => ['rgb' => 'FFFFFF'],
                'name'  => 'Cambria',
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '000000'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $style6 = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'wrapText'        => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];

        $style7 = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'font'  => [
                'bold'  => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7E6E6'], // Corrected 'startColor' key
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];


        if ($fetchQOPR[0]['office'] === 'ORD' || $fetchQOPR[0]['office'] === 'ORD-Legal' || $fetchQOPR[0]['office'] === 'ORD-Planning' || $fetchQOPR[0]['office'] === 'ORD-Rictu') {
            $sheet->getCell('E' . $row)->setValue('Prepared by:');
            // $sheet->getCell('L'.$row)->setValue('Reviewed by:');
            $sheet->getCell('Q' . $row)->setValue('Reviewed and Approved by:');
            $sheet->getStyle("E" . $row . ':K' . $row)->applyFromArray($style5);
            $sheet->getStyle("Q" . $row . ':V' . $row)->applyFromArray($style5);
            $sheet->mergeCells('E' . $row . ':K' . $row);
            // $sheet->mergeCells('L'.$row.':P'.$row);
            $sheet->mergeCells('Q' . $row . ':V' . $row);


            $row = ++$row;
            $a = $row + 5;

            $sheet->getCell('E' . $row)->setValue($fetchQOPR[0]['process_owner']);
            $sheet->getStyle("E" . $row . ':K' . $a)->applyFromArray($style6);
            $sheet->mergeCells('E' . $row . ':K' . $a);

            // $sheet->getCell('L' . $row)->setValue($approver);
            // $sheet->getStyle("L" . $row . ':P' . $a)->applyFromArray($style6);
            // $sheet->mergeCells('L' . $row . ':P' . $a);

            $sheet->getCell('Q' . $row)->setValue('DARRELL I. DIZON');
            $sheet->getStyle("Q" . $row . ':V' . $a)->applyFromArray($style6);
            $sheet->mergeCells('Q' . $row . ':V' . $a);

            $row = $row + 6;
            $sheet->getCell('E' . $row)->setValue('Process Owner');
            $sheet->getStyle("E" . $row . ':K' . $row)->applyFromArray($style7);
            $sheet->mergeCells('E' . $row . ':K' . $row);

            // $sheet->getCell('L' . $row)->setValue('Regional QMR Deputy');
            // $sheet->getStyle("L" . $row . ':P' . $row)->applyFromArray($style7);
            // $sheet->mergeCells('L' . $row . ':P' . $row);

            $sheet->getCell('Q' . $row)->setValue('Regional QMR');
            $sheet->getStyle("Q" . $row . ':V' . $row)->applyFromArray($style7);
            $sheet->mergeCells('Q' . $row . ':V' . $row);
        } else {
            $sheet->getCell('E' . $row)->setValue('Prepared by:');
            $sheet->getCell('L' . $row)->setValue('Reviewed by:');
            $sheet->getCell('Q' . $row)->setValue('Approved by:');
            $sheet->getStyle("E" . $row . ':V' . $row)->applyFromArray($style5);
            $sheet->mergeCells('E' . $row . ':K' . $row);
            $sheet->mergeCells('L' . $row . ':P' . $row);
            $sheet->mergeCells('Q' . $row . ':V' . $row);


            $row = ++$row;
            $a = $row + 5;

            $sheet->getCell('E' . $row)->setValue($fetchQOPR[0]['process_owner']);
            $sheet->getStyle("E" . $row . ':K' . $a)->applyFromArray($style6);
            $sheet->mergeCells('E' . $row . ':K' . $a);

            $sheet->getCell('L' . $row)->setValue($approver);
            $sheet->getStyle("L" . $row . ':P' . $a)->applyFromArray($style6);
            $sheet->mergeCells('L' . $row . ':P' . $a);

            $sheet->getCell('Q' . $row)->setValue('DARRELL I. DIZON');
            $sheet->getStyle("Q" . $row . ':V' . $a)->applyFromArray($style6);
            $sheet->mergeCells('Q' . $row . ':V' . $a);

            $row = $row + 6;
            $sheet->getCell('E' . $row)->setValue('Process Owner');
            $sheet->getStyle("E" . $row . ':K' . $row)->applyFromArray($style7);
            $sheet->mergeCells('E' . $row . ':K' . $row);

            $sheet->getCell('L' . $row)->setValue('Regional Deputy QMR');
            $sheet->getStyle("L" . $row . ':P' . $row)->applyFromArray($style7);
            $sheet->mergeCells('L' . $row . ':P' . $row);

            $sheet->getCell('Q' . $row)->setValue('Regional QMR');
            $sheet->getStyle("Q" . $row . ':V' . $row)->applyFromArray($style7);
            $sheet->mergeCells('Q' . $row . ':V' . $row);
        }





        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        // $fileName = 'test.xlsx';
        $fileName = $fetchQOPR[0]['qp_code'].' - '. $fetchQOPR[0]['qp_covered']. '.xlsx';
        $writer->save($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
