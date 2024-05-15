<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class PurchaseOrderModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_purchase_order';

    protected $fillable = [
        'id',
        'supplier_id',
        'abstract_id',
        'po_no',
        'rfq_no',
        'po_date',
        'noa_date',
        'ntp_date',
        'po_amount',
    ];
}
