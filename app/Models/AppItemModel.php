<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class AppItemModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_app';


    protected $fillable = [
        'id',
        'sn',
        'code',
        'new_entry',
        'merge_code',
        'item_title',
        'unit_id',
        'source_of_funds_id',
        'category_id',
        'pmo_id',
        'quantity',
        'mode',
        'price',
        'app_price',
        'remarks',
        'app_year',
        'created_at',
        'description'
    ];
}
