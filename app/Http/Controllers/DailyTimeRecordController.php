<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserModel;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DailyTimeRecord;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DailyTimeRecordExport;
use App\Imports\DailyTimeRecordImport;
use App\Exports\SingleEmployeeDTRSheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class DailyTimeRecordController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = trim($request->get('search', ''));

        $query = UserModel::whereHas('dailyTimeRecords');

        if ($search) {
            $query->whereRaw(
                "MATCH(first_name, last_name) AGAINST(? IN BOOLEAN MODE)",
                [$search . '*']
            );
        }

        $users = $query->select('id', 'first_name', 'last_name')
            ->paginate($perPage);

        $users->getCollection()->transform(function ($user) {
            $user->name = $user->first_name . ' ' . $user->last_name;
            $user->date_generated = DailyTimeRecord::where('user_id', $user->id)
                ->orderBy('date_generated', 'desc')
                ->value('date_generated');
            return $user;
        });



        return response()->json($users);
    }


    public function show($id)
    {
        $record = DailyTimeRecord::find($id);

        if (!$record) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        return response()->json($record);
    }


    public function storeBulk(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'records' => 'required|array',
            'records.*.date' => 'required|date',
            'records.*.time_in_am' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.time_out_am' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.time_in_pm' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.time_out_pm' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.undertime' => 'nullable|string|max:255',
        ]);

        $user = User::find($validated['user_id']);

        DB::transaction(function () use ($validated, $user) {
            foreach ($validated['records'] as $record) {
                DailyTimeRecord::updateOrCreate(
                    [
                        'user_id' => $validated['user_id'],
                        'date' => $record['date'],
                    ],
                    [
                        'employee_no' => $user->employee_no,
                        'time_in_am' => $record['time_in_am'] ?? null,
                        'time_out_am' => $record['time_out_am'] ?? null,
                        'time_in_pm' => $record['time_in_pm'] ?? null,
                        'time_out_pm' => $record['time_out_pm'] ?? null,
                        'undertime' => $record['undertime'] ?? null,
                    ]
                );
            }
        });

        return response()->json(['message' => 'Records saved successfully'], 201);
    }



    public function getByUser(Request $request, $userId)
    {
        $user = UserModel::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $month = $request->query('month'); // Expected format YYYY-MM

        if (!$month) {
            return response()->json(['error' => 'Month parameter is required'], 400);
        }

        try {
            $startOfMonth = Carbon::parse($month . '-01')->startOfMonth();
            $endOfMonth = Carbon::parse($month . '-01')->endOfMonth();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid month format. Use YYYY-MM.'], 400);
        }

        // Fetch existing records keyed by date
        $records = DailyTimeRecord::where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date')
            ->get()
            ->keyBy(function ($item) {
                return $item->date->toDateString(); // Make sure $item->date is a Carbon instance or cast to string
            });

        $allDates = [];
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateStr = $date->toDateString();

            if (isset($records[$dateStr])) {
                $record = $records[$dateStr];
                $allDates[] = [
                    'id' => $record->id,
                    'date' => $dateStr,
                    'employee_no' => $record->employee_no, // Include employee_no
                    'time_in_am' => $record->time_in_am,
                    'time_out_am' => $record->time_out_am,
                    'time_in_pm' => $record->time_in_pm,
                    'time_out_pm' => $record->time_out_pm,
                    'undertime' => $record->undertime,

                ];
            } else {
                // No record exists for this date — add empty default record
                $allDates[] = [
                    'id' => null,
                    'date' => $dateStr,
                    'employee_no' => $user->employee_no, // Include employee_no
                    'time_in_am' => null,
                    'time_out_am' => null,
                    'time_in_pm' => null,
                    'time_out_pm' => null,
                    'undertime' => null,
                ];
            }
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'employee_no' => $user->employee_no, // Include employee_no
            ],
            'records' => $allDates,
        ]);
    }

    public function updateByUser(Request $request, $userId)
    {
        $validated = $request->validate([
            'records' => 'required|array',
            'records.*.id' => 'required|exists:tbl_daily_time_records,id',
            'records.*.time_in_am' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.time_out_am' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.time_in_pm' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.time_out_pm' => [
                'nullable',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/'
            ],
            'records.*.undertime' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['records'] as $recordData) {
                $record = DailyTimeRecord::find($recordData['id']);
                if ($record) {
                    $updateData = [];

                    if (array_key_exists('time_in_am', $recordData)) {
                        $updateData['time_in_am'] = $recordData['time_in_am'];
                    }
                    if (array_key_exists('time_out_am', $recordData)) {
                        $updateData['time_out_am'] = $recordData['time_out_am'];
                    }
                    if (array_key_exists('time_in_pm', $recordData)) {
                        $updateData['time_in_pm'] = $recordData['time_in_pm'];
                    }
                    if (array_key_exists('time_out_pm', $recordData)) {
                        $updateData['time_out_pm'] = $recordData['time_out_pm'];
                    }
                    if (array_key_exists('undertime', $recordData)) {
                        $updateData['undertime'] = $recordData['undertime'];
                    }

                    if (!empty($updateData)) {
                        $record->update($updateData);
                    }
                }
            }
        });

        return response()->json(['message' => 'Records updated successfully']);
    }



    public function destroy($id)
    {
        $record = DailyTimeRecord::findOrFail($id);
        $record->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
        ]);

        $author = auth()->user()->id ?? 'unknown'; // or get from session kung walang auth

        Excel::import(
            new DailyTimeRecordImport($validated['date_from'], $validated['date_to'], $author),
            $validated['file']
        );

        return response()->json(['message' => 'Records imported successfully']);
    }




    public function export(Request $request)
    {
        $validated = $request->validate([
            'office' => 'required|integer',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $officeId = $validated['office'];
        $month = $validated['month'];
        $year = $validated['year'];

        $office = DB::table('pmo')->where('id', $officeId)->first();
        $divisionName = $office->pmo_title ?? 'Office';

        $users = User::where('pmo_id', $officeId)->get();

        // ✅ NEW: Get user IDs
        $userIds = $users->pluck('id');

        // ✅ NEW: Update all matching DTRs to add date_generated = today
        DailyTimeRecord::whereIn('user_id', $userIds)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->update(['date_generated' => now()]);

        $path = public_path('templates/export_dtr.xlsx');

        if (!file_exists($path)) {
            throw new \Exception("Template not found at: {$path}");
        }

        $spreadsheet = IOFactory::load($path);
        $templateSheet = $spreadsheet->getActiveSheet();

        $richText = new RichText();
        $richText->createText('For the Month of ');
        $boldText = $richText->createTextRun(date('F Y', strtotime("{$validated['year']}-{$validated['month']}-01")));
        $boldText->getFont()->setBold(true);
        $templateSheet->setCellValue('A8', $richText);
        $templateSheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        foreach ($users as $user) {
            $newSheet = clone $templateSheet;
            $newSheet->setTitle(substr($user->first_name . '_' . $user->last_name, 0, 30));

            $newSheet->setCellValue('A6', "{$user->last_name}, {$user->first_name}");
            $newSheet->setCellValue('A8', 'For the Month of ' . date('F Y', strtotime("{$year}-{$month}-01")));

            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();

            $records = DailyTimeRecord::where('user_id', $user->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get()
                ->keyBy(function ($item) {
                    return Carbon::parse($item->date)->format('Y-m-d');
                });

            $row = 14;

            $spreadsheet->addSheet($newSheet);
            $richText = new RichText();
            $richText->createText('For the Month of ');
            $boldText = $richText->createTextRun(date('F Y', strtotime("{$validated['year']}-{$validated['month']}-01")));
            $boldText->getFont()->setBold(true);
            $newSheet->setCellValue('A8', $richText);
            $newSheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            while ($startDate->lte($endDate)) {
                $date = $startDate->toDateString(); // 'YYYY-MM-DD'
                $record = $records->get($date);

                $newSheet->setCellValue('A' . $row, $startDate->format('F d, Y'));
                $newSheet->setCellValue('B' . $row, $record && $record->time_in_am ? date('h:i A', strtotime($record->time_in_am)) : '');
                $newSheet->setCellValue('C' . $row, $record && $record->time_out_am ? date('h:i A', strtotime($record->time_out_am)) : '');
                $newSheet->setCellValue('D' . $row, $record && $record->time_in_pm ? date('h:i A', strtotime($record->time_in_pm)) : '');
                $newSheet->setCellValue('E' . $row, $record && $record->time_out_pm ? date('h:i A', strtotime($record->time_out_pm)) : '');

                $hours = 0;
                $minutes = 0;

                if ($record && $record->undertime && trim($record->undertime) !== '') {
                    if (strpos($record->undertime, 'h') !== false || strpos($record->undertime, 'm') !== false) {
                        if (preg_match('/(\d+)h/', $record->undertime, $h)) {
                            $hours = (int) $h[1];
                        }
                        if (preg_match('/(\d+)m/', $record->undertime, $m)) {
                            $minutes = (int) $m[1];
                        }
                    } elseif (strpos($record->undertime, ':') !== false) {
                        [$hours, $minutes] = explode(':', $record->undertime);
                        $hours = (int) $hours;
                        $minutes = (int) $minutes;
                    } else {
                        $hours = (int) $record->undertime;
                    }
                }

                $newSheet->setCellValue('F' . $row, ($hours > 0) ? $hours : '');
                $newSheet->setCellValue('G' . $row, ($minutes > 0) ? $minutes : '');

                $cellRange = 'A' . $row . ':G' . $row;
                $newSheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $newSheet->getRowDimension($row)->setRowHeight(21);

                $startDate->addDay();
                $row++;
            }

            // Certification block (unchanged)
            $row2 = $row + 2;
            $row3 = $row2 + 2;
            $row4 = $row3 + 2;
            $row5 = $row4 + 2;
            $row6 = $row5 + 1;

            $newSheet->mergeCells("A{$row2}:G{$row2}");
            $newSheet->setCellValue("A{$row2}", "I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.");
            $newSheet->getRowDimension($row2)->setRowHeight(30);
            $newSheet->getStyle("A{$row2}")->getFont()->setItalic(true);
            $newSheet->getStyle("A{$row2}")->getAlignment()->setWrapText(true);
            $newSheet->getStyle("A{$row2}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $newSheet->setCellValue("A{$row4}", "VERIFIED as to the prescribed office hours:");

            $newSheet->mergeCells("C{$row3}:E{$row3}");
            $newSheet->mergeCells("C{$row5}:E{$row5}");
            $newSheet->mergeCells("C{$row6}:E{$row6}");

            $newSheet->getStyle("C{$row3}:E{$row3}")->applyFromArray([
                'borders' => [
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ]);
            $newSheet->getStyle("C{$row5}:E{$row5}")->applyFromArray([
                'borders' => [
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ]);

            $newSheet->setCellValue("C{$row5}", '');
            $newSheet->getStyle("C{$row5}")->getFont()->setBold(true);

            $newSheet->setCellValue("C{$row6}", "In Charge");
            $newSheet->getStyle("C{$row6}")->getFont()->setSize(11);
            $newSheet->getStyle("C{$row6}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Remove the original template sheet
        $spreadsheet->removeSheetByIndex(0);

        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $fileName = "{$divisionName}_DTR_{$monthName}_{$year}.xlsx";
        $tempPath = storage_path("app/{$fileName}");

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }


    public function exportUser(Request $request, $userId)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $user = User::findOrFail($userId);

        $path = public_path('templates/export_dtr.xlsx');

        if (!file_exists($path)) {
            throw new \Exception("Template not found at: {$path}");
        }

        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A6', "{$user->last_name}, {$user->first_name}");
        $richText = new RichText();
        $richText->createText('For the Month of ');
        $boldText = $richText->createTextRun(date('F Y', strtotime("{$validated['year']}-{$validated['month']}-01")));
        $boldText->getFont()->setBold(true);
        $sheet->setCellValue('A8', $richText);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Get records and index by date string
        $records = DailyTimeRecord::where('user_id', $user->id)
            ->whereMonth('date', $validated['month'])
            ->whereYear('date', $validated['year'])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        // Loop whole month
        $startDate = Carbon::create($validated['year'], $validated['month'], 1);
        $endDate = $startDate->copy()->endOfMonth();
        $row = 14;

        while ($startDate->lte($endDate)) {
            $date = $startDate->toDateString();
            $record = $records->get($date);

            $sheet->setCellValue('A' . $row, $startDate->format('F d, Y'));

            $time_in_am = $record && $record->time_in_am ? date('h:i A', strtotime($record->time_in_am)) : '';
            $time_out_am = $record && $record->time_out_am ? date('h:i A', strtotime($record->time_out_am)) : '';
            $time_in_pm = $record && $record->time_in_pm ? date('h:i A', strtotime($record->time_in_pm)) : '';
            $time_out_pm = $record && $record->time_out_pm ? date('h:i A', strtotime($record->time_out_pm)) : '';

            $sheet->setCellValue('B' . $row, $time_in_am);
            $sheet->setCellValue('C' . $row, $time_out_am);
            $sheet->setCellValue('D' . $row, $time_in_pm);
            $sheet->setCellValue('E' . $row, $time_out_pm);

            // Parse undertime if record exists
            $hours = 0;
            $minutes = 0;

            if ($record && $record->undertime && trim($record->undertime) !== '') {
                if (strpos($record->undertime, 'h') !== false || strpos($record->undertime, 'm') !== false) {
                    if (preg_match('/(\d+)h/', $record->undertime, $h)) {
                        $hours = (int) $h[1];
                    }
                    if (preg_match('/(\d+)m/', $record->undertime, $m)) {
                        $minutes = (int) $m[1];
                    }
                } elseif (strpos($record->undertime, ':') !== false) {
                    [$hours, $minutes] = explode(':', $record->undertime);
                    $hours = (int) $hours;
                    $minutes = (int) $minutes;
                } else {
                    $hours = (int) $record->undertime;
                }
            }

            $sheet->setCellValue('F' . $row, ($hours > 0) ? $hours : '');
            $sheet->setCellValue('G' . $row, ($minutes > 0) ? $minutes : '');

            $sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(21);

            $startDate->addDay();
            $row++;
        }

        // Certification block
        $row2 = $row + 2;
        $row3 = $row2 + 2;
        $row4 = $row3 + 2;
        $row5 = $row4 + 2;
        $row6 = $row5 + 1;

        $sheet->mergeCells("A{$row2}:G{$row2}");
        $sheet->setCellValue("A{$row2}", "I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.");
        $sheet->getRowDimension($row2)->setRowHeight(30);
        $sheet->getStyle("A{$row2}")->getFont()->setItalic(true);
        $sheet->getStyle("A{$row2}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("A{$row2}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue("A{$row4}", "VERIFIED as to the prescribed office hours:");
        $sheet->mergeCells("C{$row3}:E{$row3}");
        $sheet->mergeCells("C{$row5}:E{$row5}");
        $sheet->mergeCells("C{$row6}:E{$row6}");

        $sheet->getStyle("C{$row3}:E{$row3}")->applyFromArray([
            'borders' => [
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);
        $sheet->getStyle("C{$row5}:E{$row5}")->applyFromArray([
            'borders' => [
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        $sheet->setCellValue("C{$row5}", '');
        $sheet->getStyle("C{$row5}")->getFont()->setBold(true);

        $sheet->setCellValue("C{$row6}", "In Charge");
        $sheet->getStyle("C{$row6}")->getFont()->setSize(11);
        $sheet->getStyle("C{$row6}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $monthName = date('F', mktime(0, 0, 0, $validated['month'], 1));
        $fileName = "{$user->first_name}_{$user->last_name}_DTR_{$monthName}_{$validated['year']}.xlsx";
        $tempPath = storage_path("app/{$fileName}");

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
