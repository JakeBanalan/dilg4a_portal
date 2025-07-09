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

            // ✅ Compute undertime only if IN/OUT present
            if ($record->time_in_am && $record->time_out_pm) {
                $this->calculateUndertime($record);
            }

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
        $schedOutPM = 17 * 3600; // 5:00 PM in seconds

        $inAM = $timeToSeconds($record->time_in_am);
        $outPM = $timeToSeconds($record->time_out_pm);

        if (is_null($inAM) || is_null($outPM)) {
            $record->undertime = '480m'; // whole day
            return;
        }

        // Flex offset → seconds
        $flexOffset = $schedInAM - $inAM;
        $expectedOutPM = $schedOutPM - $flexOffset;

        $undertime = 0;
        if ($outPM < $expectedOutPM) {
            $undertime = $expectedOutPM - $outPM;
        }

        // Format undertime back to H M
        $hrs = floor($undertime / 3600);
        $mins = floor(($undertime % 3600) / 60);

        $record->undertime = ($undertime <= 0) ? ' ' : trim(($hrs ? "{$hrs}h " : '') . "{$mins}m");
    }
}
