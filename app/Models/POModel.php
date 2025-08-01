<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class POModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_purchase_order';
    protected $fillable = [
        'id',
        'po_no',
        'rfq_id',
        'abstract_id',
        'supplier_id',
        'po_date',
        'updated_at',
        'created_at'
    ];
}
