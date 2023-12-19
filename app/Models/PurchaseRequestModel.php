<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class PurchaseRequestModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'pr';
    protected $fillable = [
        'id',
        'pr_no',
        'pmo',
        'fund_source',
        'type',
        'pr_date',
        'target_date',
        'submitted_date',
        'received_date',
        'status',
        'availability_code',
        'is_urgent',
        'requested_by',
    ];
}
