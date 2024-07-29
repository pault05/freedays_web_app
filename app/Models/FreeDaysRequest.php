<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'days',
        'description',
        'days',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function files() : HasMany {
        return $this->hasMany(FreeDaysReqFile::class, 'free_days_request_id');
    }

}
