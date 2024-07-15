<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class QGAModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qms_gap_analysis';
    protected $fillable = [
        'id',
        'qop_entry_id',
        'qoe_id',
        'is_gap_analysis',
        'gap_analysis',
        'created_at',
        'updated_at'
    ];
}
