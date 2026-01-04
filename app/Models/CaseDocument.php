<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'lawyer_case_id',
        'file_path',
        'file_name',
        'uploaded_by',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(LawyerCase::class, 'lawyer_case_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
