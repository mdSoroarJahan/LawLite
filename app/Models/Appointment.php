<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AppointmentFactory>
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'user_id', 'date', 'time', 'status', 'type', 'notes'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Lawyer, \App\Models\Appointment>
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Appointment>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
