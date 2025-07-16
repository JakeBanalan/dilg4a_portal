<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_disbursement';
    protected $primaryKey = 'ID';

    // If your primary key is not auto-incrementing, set this to false
    // public $incrementing = false;

    // If your primary key is not an integer, specify the type
    // protected $keyType = 'string';

    protected $fillable = [
        'burs_id',
        'office',
        'po_no',
        'dv',
        'ors',
        'sr',
        'ppa',
        'uacs',
        'datereceived',
        'timereceived',
        'payee',
        'particular',
        'amount',
        'tax',
        'gsis',
        'pagibig',
        'philhealth',
        'other',
        'total',
        'net',
        'date_proccess',
        'datereleased',
        'timereleased',
        'datereturned',
        'timereturned',
        'remarks',
        'status',
        'flag',
        'orsdate',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($disbursement) {
            Log::info("Soft deleting disbursement with ID: {$disbursement->ID}");
        });

        static::deleted(function ($disbursement) {
            Log::info("Disbursement with ID: {$disbursement->ID} has been deleted");
        });

        static::restoring(function ($disbursement) {
            Log::info("Restoring disbursement with ID: {$disbursement->ID}");
        });
    }
}
