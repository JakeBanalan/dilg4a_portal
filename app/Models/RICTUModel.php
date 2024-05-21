<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class RICTUModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tbl_technicalassistance';
    protected $fillable = [
        'id',
        'control_no',
        'request_by',
        'request_date',
        'css_link',
        'office_id',
        'request_type_category_id',
        'request_type_id',
        'others',
        'portal_system',
        'website_access',
        'ict_officer_remarks',
        'remarks',
        'assign_ict_officer',
        'ict_personnel',
        'received_date',
        'started_date',
        'completed_date',
        'equipment_type',
        'brand',
        'property_no',
        'serial_no',
        'status_id',
        'updated_at',
        'created_at'
    ];
}
