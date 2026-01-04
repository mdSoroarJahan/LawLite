<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AnalyticsFactory>
 * @method static \Database\Factories\AnalyticsFactory factory(...$parameters)
 */
class Analytics extends Model
{
    use HasFactory;

    protected $fillable = ['lawyer_id', 'total_messages', 'total_appointments', 'avg_response_time'];

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Lawyer, \App\Models\Analytics> */
    /** @phpstan-ignore-next-line */
    public function lawyer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Lawyer::class);
    }
}
