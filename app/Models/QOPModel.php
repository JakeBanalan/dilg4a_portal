<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class QOPModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qoe';
    protected $fillable = [
        'id',
        'qop_id',
        'objective',
        'target_percentage',
        'indicator_a',
        'indicator_b',
        'indicator_c',
        'indicator_d',
        'indicator_e',
        'date_created',
        'created_by',
        'date_updated',
        'updated_by',
        'formula',
        'is_gap_analysis',
        'gap_analysis',
        'created_at',
        'updated_at',
    ];
}
