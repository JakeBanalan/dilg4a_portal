<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class FundSourceModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_fundsource';
    protected $fillable = [
        'id', 
        'source', 
        'name', 
        'ppa', 
        'legal_basis', 
        'particulars', 
        'total_allotment_amoount', 
        'total_allotment_obligated', 
        'total_balance', 
        'status',
        'created_by',
        'date_created', 
        'is_lock',
        'created_at', 
        'updated_at'
    ];
}
