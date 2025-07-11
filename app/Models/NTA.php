<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NTA extends Model
{
    use HasFactory;

    protected $table = 'tbl_nta';

    protected $fillable = [
        'nta_date',
        'received_date',
        'nta_number',
        'saro_number',
        'account_number',
        'particular',
        'quarter',
        'amount',
        'obligated',
        'balance',
        'created_by',
        'date_created',
        'status',
        'is_lock',
    ];
}
