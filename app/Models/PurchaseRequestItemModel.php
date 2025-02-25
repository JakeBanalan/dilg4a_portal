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
        'pr_no',
        'pr_item_id',
        'description',
        'unit',
        'qty',
        'abc',
        'date_added',
        'flag'
    ];

    public function appItem()
    {
        return $this->belongsTo(AppItemModel::class, 'pr_item_id', 'id');
    }
}
