<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class QMSHistoryModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qms_sub_history';
    protected $fillable = [
         'id', 
         'qop_entry_id', 
         'date_created',
         'created_by', 
         'status', 
         'remarks', 
         'created_at',
         'updated_at'
    ];
}
