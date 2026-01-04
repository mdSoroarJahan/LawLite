<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Database\Factories\AdminVerificationFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AdminVerificationFactory>
 */
class AdminVerification extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'verified_by', 'date_verified'];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Lawyer, \App\Models\AdminVerification> */
    /** @phpstan-ignore-next-line */
    public function lawyer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lawyer::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\AdminVerification> */
    /** @phpstan-ignore-next-line */
    public function verifier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Lawyer, \App\Models\AdminVerification> */
    /** @phpstan-ignore-next-line */
    public function lawyerRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        // alias to satisfy static analysis when referencing the relationship
        return $this->belongsTo(Lawyer::class);
    }
}
