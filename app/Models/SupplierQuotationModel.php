<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class SupplierQuotationModel extends Model
{
   
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_supplier_quotation';
    protected $fillable = [
        'id',
        'supplier_id',
        'rfq_id',
        'item_id',
        'quotation',
        'winner'
    ];
}
