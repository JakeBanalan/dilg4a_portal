<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class ResolutionModel extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'tbl_resolution';

    protected $fillable = [
        'reso_no',
        'abstract_id',
        'rfq_id',
        'reso_date',
        'reso_content',
    ];
    protected $casts = [
        'reso_content' => 'array', // <<< Add this line
    ];

    public function abstract()
    {
        return $this->belongsTo(AbstractModel::class, 'abstract_id');
    }
}
