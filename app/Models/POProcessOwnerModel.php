<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class POProcessOwnerModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_qms_po_process_owner';
    protected $fillable = [
        'id',
        'qop_id',
        'pmo_id',
        'parent_p_owner',
        'po_process_owner',
        'program_manager',
        'provincial_qmr',
        'created_at',
        'updated_at'
    ];
}
