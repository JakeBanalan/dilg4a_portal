<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class SaroModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_budget_saro';
    protected $fillable = [
        'id', 
        'sarodate', 
        'saronumber', 
        'fund', 
        'legalbasis', 
        'ppa', 
        'expenseclass', 
        'particulars', 
        'uacs', 
        'amount',
        'created_by',
        'obligated', 
        'balance',
        'sarogroup'
    ];
}
