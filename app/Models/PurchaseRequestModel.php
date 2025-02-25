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
        'purpose',
        'pmo',
        'fund_source',
        'action_officer',
        'current_step',
        'type',
        'pr_date',
        'target_date',
        'submitted_date',
        'received_date',
        'stat',
        'availability_code',
        'is_urgent',
        'requested_by',
        'updated_at',
        'created_at',
        'current_step',
        'name',
        'email'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseRequestItemModel::class, 'pr_id');
    }
}
