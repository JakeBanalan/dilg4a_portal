<?php

namespace App\Imports;

use App\Models\User;
use App\Models\DailyTimeRecord;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class DailyTimeRecordImport implements ToCollection
{
    protected $dateFrom;
    protected $dateTo;
    protected $author;

    public function __construct($dateFrom, $dateTo, $author)
    {
        $this->dateFrom = Carbon::parse($dateFrom)->startOfDay();
        $this->dateTo = Carbon::parse($dateTo)->endOfDay();
        $this->author = $author;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row[0]) || empty($row[0])) {
                continue; // Skip blank rows
            }

            $emp_no = $row[0];
            $dateTimeRaw = $row[1];
            $state = intval($row[3]);

            // Log original data
            // Log::info('Raw Row', ['emp_no' => $emp_no, 'datetime_raw' => $dateTimeRaw, 'state' => $state]);

            // ✅ Handle numeric Excel date
            if (is_numeric($dateTimeRaw)) {
                $dateTime = ExcelDate::excelToDateTimeObject($dateTimeRaw);
            } else {
                $dateTime = Carbon::parse($dateTimeRaw);
            }

            $date = $dateTime->format('Y-m-d');
            $time = $dateTime->format('H:i:s');

            // ✅ Filter records based on selected date range
            $recordDate = Carbon::parse($date);
            if ($recordDate->lt($this->dateFrom) || $recordDate->gt($this->dateTo)) {
                continue; // Skip records outside the selected date range
            }

            $user = User::where('employee_no', $emp_no)->first();

            if (!$user) {
                Log::warning("No user found for employee_no: {$emp_no}");
                continue;
            }

            $record = DailyTimeRecord::firstOrNew([
                'user_id' => $user->id,
                'date' => $date,
            ]);

            if ($state === 0) {
                $record->time_in_am = $time;
            } elseif ($state === 1) {
                $record->time_out_am = $time;
            } elseif ($state === 2) {
                $record->time_in_pm = $time;
            } elseif ($state === 3) {
                $record->time_out_pm = $time;
            }

            $record->employee_no = $emp_no;

            // ✅ Calculate undertime whenever we have any time data
            $this->calculateUndertime($record);

            $record->save();

            // Log::info('Saved DTR Record', [
            //     'user_id' => $user->id,
            //     'date' => $date,
            //     'in_am' => $record->time_in_am,
            //     'out_pm' => $record->time_out_pm,
            //     'undertime' => $record->undertime
            // ]);
        }
    }

    protected function calculateUndertime($record)
    {
        $timeToSeconds = function ($timeStr) {
            if (!$timeStr) return null;
            [$h, $m, $s] = explode(':', $timeStr);
            return intval($h) * 3600 + intval($m) * 60 + intval($s);
        };

        $schedInAM = 8 * 3600;   // 8:00 AM in seconds
        $schedOutAM = 12 * 3600; // 12:00 PM in seconds (lunch break)
        $schedInPM = 13 * 3600;  // 1:00 PM in seconds (back from lunch)
        $schedOutPM = 17 * 3600; // 5:00 PM in seconds

        $inAM = $timeToSeconds($record->time_in_am);
        $outAM = $timeToSeconds($record->time_out_am);
        $inPM = $timeToSeconds($record->time_in_pm);
        $outPM = $timeToSeconds($record->time_out_pm);

        $totalUndertime = 0;

        // Case 1: Only morning shift (like your example: 08:14:32 12:08:18 NULL NULL)
        if ($inAM && $outAM && !$inPM && !$outPM) {
            // Calculate morning work hours
            $morningWorked = $outAM - $inAM;
            $expectedMorningWork = $schedOutAM - $schedInAM; // 4 hours
            
            // Missing entire afternoon (4 hours)
            $afternoonMissed = $schedOutPM - $schedInPM; // 4 hours
            
            // Calculate undertime
            $morningUndertime = max(0, $expectedMorningWork - $morningWorked);
            $totalUndertime = $morningUndertime + $afternoonMissed;
        }
        // Case 2: Full day with flexible time
        elseif ($inAM && $outPM) {
            // Calculate flex offset
            $flexOffset = $schedInAM - $inAM;
            $expectedOutPM = $schedOutPM - $flexOffset;
            
            if ($outPM < $expectedOutPM) {
                $totalUndertime = $expectedOutPM - $outPM;
            }
        }
        // Case 3: Incomplete records - calculate what's missing
        else {
            // Calculate total expected work time (8 hours)
            $expectedTotal = 8 * 3600;
            $actualWorked = 0;
            
            // Add morning work if present
            if ($inAM && $outAM) {
                $actualWorked += ($outAM - $inAM);
            }
            
            // Add afternoon work if present
            if ($inPM && $outPM) {
                $actualWorked += ($outPM - $inPM);
            }
            
            $totalUndertime = max(0, $expectedTotal - $actualWorked);
        }

        // Format undertime back to H M
        $hrs = floor($totalUndertime / 3600);
        $mins = floor(($totalUndertime % 3600) / 60);

        $record->undertime = ($totalUndertime <= 0) ? '' : trim(($hrs ? "{$hrs}h " : '') . ($mins ? "{$mins}m" : ''));
    }
}