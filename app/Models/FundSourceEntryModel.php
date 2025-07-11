<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class FundSourceEntryModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_fundsource_entry';
    protected $fillable = [
        'id', 
        'source_id', 
        'expense_class', 
        'uacs', 
        'allotment_amount', 
        'obligated_amount', 
        'balance', 
        'is_lock', 
    ];
}
