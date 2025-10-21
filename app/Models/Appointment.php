<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'user_id', 'date', 'time', 'status', 'type', 'notes'];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
