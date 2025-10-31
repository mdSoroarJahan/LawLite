<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AdminVerificationFactory>
 */
class AdminVerification extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'verified_by', 'date_verified'];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function lawyerRelation()
    {
        // alias to satisfy static analysis when referencing the relationship
        return $this->belongsTo(Lawyer::class);
    }
}
