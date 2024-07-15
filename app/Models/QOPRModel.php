<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class QOPRModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qop_report';
    protected $fillable = [
        'id',
        'qop_id',
        'objective',
        'date_created',
        'created_by',
        'status',
        'qp_covered',
        'year',
        'created_at',
        'updated_at'
    ];
}
