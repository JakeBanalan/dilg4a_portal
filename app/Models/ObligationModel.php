<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class ObligationModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_obligation';
    protected $fillable = [
        'id',
        'type',
        'is_funds',
        'serial_no',
        'po_id',
        'supplier',
        'address',
        'purpose',
        'amount',
        'remarks',
        'status',
        'date_created',
        'created_by',
        'date_updated',
        'updated_by',
        'date_submitted',
        'submitted_by',
        'date_received',
        'received_by',
        'date_obligated',
        'obligated_by',
        'date_returned',
        'returned_by',
        'return_reason',
        'date_released',
        'released_by',
        'designation',
        'is_submitted'
    ];
}
