<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class CalendarModel extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'events';
    protected $fillable = [
       'id',
       'office',
       'title',
       'color',
       'start',
       'end',
       'description',
       'venue',
       'enp',
       'postedby',
       'posteddate',
       'realenddate',
       'cancelflag',
       'status',
       'isRead',
       'isGenerateRO',
       'remarks',
       'comments',
       'priority',
       'program',
       'is_new',
       'code_series',
       'event_reminder',
       'isSent',
       'created_at',
       'updated_at'
    ];
}