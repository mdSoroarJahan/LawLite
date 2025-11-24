<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawyerCase extends Model
{
    protected $fillable = [
        'lawyer_id',
        'title',
        'description',
        'client_name',
        'client_email',
        'client_phone',
        'hearing_date',
        'hearing_time',
        'court_location',
        'case_number',
        'status',
        'notes',
    ];

    protected $casts = [
        'hearing_date' => 'date',
        'hearing_time' => 'datetime',
    ];

    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(Lawyer::class);
    }
}
