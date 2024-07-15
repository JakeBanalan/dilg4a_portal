<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class QPModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qop';
    protected $fillable = [
        'id',
        'frequency_monitoring',
        'coverage',
        'office',
        'rev_no',
        'EffDate',
        'process_owner',
        'qp_code',
        'procedure_title',
        'created_by',
        'date_created',
        'updated_at',
        'created_at'
    ];
}
