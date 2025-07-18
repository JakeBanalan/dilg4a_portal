<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class PurchaseRequestItemModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'pr_items';
    protected $fillable = [
        'id',
        'pr_id',
        'pr_item_id',
        'description',
        'qty',
        'abc', // Total cost
        'unit_cost', // Unit cost
        'date_added',
        'flag',
    ];

    public function appItem()
    {
        return $this->belongsTo(AppItemModel::class, 'pr_item_id', 'id');
    }
    public function getGrandTotalAttribute()
    {
        return $this->qty * $this->unit_cost;
    }
}
