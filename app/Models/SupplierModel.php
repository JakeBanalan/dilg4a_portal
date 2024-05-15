<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class SupplierModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'supplier';
    protected $fillable = [
        'id',
        'supplier_title',
        'line_of_industry_id',
        'contact_person',
        'supplier_address',
        'contact_details',
        'tin_number',
        'registration_agency_id',
        'registration_valid_from',
        'registration_valid_until',
        'bp_validity_from',
        'bp_validity_until',
        'tc_validity_from',
        'tc_validity_until',
        'philgeps_reg_no',
        'prc_validity_from',
        'prc_validity_until',
        'itr_last_receipt_date',
        'remarks'

    ];
}
