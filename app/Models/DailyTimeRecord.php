<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTimeRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'tbl_daily_time_records'; // Ensure this matches your database table name

    protected $fillable = [
        'user_id',
        'employee_no', // Add employee_no here
        'date',
        'time_in_am',
        'time_out_am',
        'time_in_pm',
        'time_out_pm',
        'undertime',
        'total_hours',
        'date_generated', // Add date_generated here
    ];

    protected $casts = [
        'date' => 'date', // Ensure the date field is cast as a date
        'time_in_am' => 'string', // Cast time fields as strings
        'time_out_am' => 'string',
        'time_in_pm' => 'string',
        'time_out_pm' => 'string',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Ensure 'user_id' references 'id' in the 'users' table
    }
}
