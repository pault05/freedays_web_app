<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeDaysReqFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'free_days_req_id',
        'file_id',
    ];
}
