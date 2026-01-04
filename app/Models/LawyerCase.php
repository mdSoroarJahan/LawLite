<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LawyerCase extends Model
{
    protected $fillable = [
        'lawyer_id',
        'user_id',
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
        'outcome', // Added outcome
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

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CaseDocument::class);
    }

    public function tasks()
    {
        return $this->hasMany(CaseTask::class);
    }
}
