<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Notifications\Notifiable;

class HRSModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'users';
    protected $fillable = [
        'id', 
        'pmo_id', 
        'position_id', 
        'employee_no', 
        'last_name', 
        'first_name', 
        'middle_name', 
        'email', 
        'email_verified_at', 
        'is_activated', 
        'code', 
        'user_role', 
        'username', 
        'password', 
        'api_token', 
        'created_at', 
        'updated_at'
    ];
}
