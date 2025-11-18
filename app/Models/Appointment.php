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

    protected $fillable = ['lawyer_id', 'user_id', 'date', 'time', 'status', 'type', 'notes'];

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
}
