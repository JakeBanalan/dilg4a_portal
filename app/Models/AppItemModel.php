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
        'pmo_id',
        'item_title',
        'unit_id',
        'category_id',
        'mode',
        'remarks',
        'app_year',
        'created_at',
        'app_status',
        'created_by'
    ];
}
