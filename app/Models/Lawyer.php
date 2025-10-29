<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lawyer
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $expertise
 * @property string|null $bio
 * @property string|null $license_number
 * @property string|null $verification_status
 * @property array<string,mixed>|null $documents
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $city
 */
class Lawyer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'expertise', 'bio', 'license_number', 'verification_status', 'documents', 'latitude', 'longitude', 'city'];

    /** @var array<string,string> */
    protected $casts = [
        'documents' => 'array',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne */
    public function analytics()
    {
        return $this->hasOne(Analytics::class);
    }
}
