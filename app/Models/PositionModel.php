<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class PositionModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'tblposition';

    protected $fillable = [
        'POSITION_C',
        'POSITION_TITLE',
        'POST_CAT_C',
        'POSITION_ACRONYM',
        'SALARY_GRADE'
    ];
}
