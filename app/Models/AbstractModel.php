<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class AbstractModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_abstract';
    protected $fillable = [
        'id',
        'abstract_no',
        'rfq_no',
        'supplier_id',
        'abstract_date',
        'updated_at',
        'created_at'
    ];
}
