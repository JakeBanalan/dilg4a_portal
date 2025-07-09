<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class QOPFrequencyModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qoe_frequency_entry';
    protected $fillable = [
         'id', 
         'qop_entry_id', 
         'office_entry_id',
         'qop_id',
         'qoe_id', 
         'indicator', 
         'rate', 
         'updated_by', 
         'created_at',
         'updated_at'
    ];
}
