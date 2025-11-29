<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AppointmentFactory>
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'user_id', 'date', 'time', 'status', 'type', 'notes', 'payment_status', 'amount', 'payment_method', 'transaction_id'];

    /**
    /** @method static \Database\Factories\AppointmentFactory factory(...$parameters)
     */
    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Lawyer, \App\Models\Appointment> */
    /** @phpstan-ignore-next-line */
    public function lawyer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lawyer::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Appointment> */
    /** @phpstan-ignore-next-line */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMeetingLinkAttribute(): ?string
    {
        if ($this->type === 'online' && $this->status === 'confirmed') {
            // Generate a unique room name based on appointment ID and a secret
            $roomName = 'LawLite-Meeting-' . $this->id . '-' . md5($this->created_at . config('app.key'));
            return 'https://meet.jit.si/' . $roomName;
        }
        return null;
    }
}
