<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'pmo_id',
        'position_id',
        'employee_no',
        'last_name',
        'first_name',
        'middle_name',
        'ext_name',
        'gender',
        'birthdate',
        'contact_details',
        'email',
        'employment_status',
        'code',
        'user_role',
        'username',
        'password',
        'office',
        'province',
        'citymun',
        'is_activated',
        'section',
        'division'
    ];

    protected $hidden = ['password', 'remember_token', 'code'];

    public function dailyTimeRecords()
    {
        return $this->hasMany(DailyTimeRecord::class, 'user_id');
    }
}
