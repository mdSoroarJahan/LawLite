<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawyerAvailability extends Model
{
    protected $fillable = [
        'lawyer_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
    ];

    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(Lawyer::class);
    }
}
