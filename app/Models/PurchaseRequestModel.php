<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestModel extends Model
{
    use HasFactory;

    protected $table = 'pr';

    protected $fillable = [
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
        'stat', // Maps to status_id
        'status', // Status text (e.g., "Return by Budget")
        'availability_code',
        'is_urgent',
        'requested_by',
        'is_budget_submitted',
        'is_gss_submitted',
        'is_ord_submitted',
        'submitted_by', // User ID who submitted
        'submitted_date_budget',
        'submitted_date_gss',
        'submitted_date_ord',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'is_budget_submitted' => 'boolean',
        'is_gss_submitted' => 'boolean',
        'is_ord_submitted' => 'boolean',
        'pr_date' => 'date',
        'target_date' => 'date',
        'submitted_date' => 'datetime',
        'submitted_date_budget' => 'datetime',
        'submitted_date_gss' => 'datetime',
        'submitted_date_ord' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseRequestItemModel::class, 'pr_id');
    }
}
