<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseTask extends Model
{
    protected $fillable = ['lawyer_case_id', 'title', 'due_date', 'is_completed'];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function case()
    {
        return $this->belongsTo(LawyerCase::class, 'lawyer_case_id');
    }
}
