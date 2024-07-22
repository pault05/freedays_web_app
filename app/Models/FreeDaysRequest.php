<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreeDaysRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'free_days_requests';
    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'half_day',
        'starting_date',
        'ending_date',
        'description',
    ];
}
