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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Lawyer, \App\Models\AdminVerification>
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\AdminVerification>
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Lawyer, \App\Models\AdminVerification>
     */
    public function lawyerRelation()
    {
        // alias to satisfy static analysis when referencing the relationship
        return $this->belongsTo(Lawyer::class);
    }
}
