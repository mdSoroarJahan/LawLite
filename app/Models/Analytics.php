<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AnalyticsFactory>
 */
class Analytics extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'total_messages', 'total_appointments', 'avg_response_time'];

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
}
