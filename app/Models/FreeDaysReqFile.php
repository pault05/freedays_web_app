<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreeDaysReqFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'free_days_req_id',
        'file_id',
    ];

    public function file() : BelongsTo
    {
        return $this->belongsTo(File::class);
    }

}
