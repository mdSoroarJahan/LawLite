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
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\LawyerFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\LawyerFactory>
 */
class Lawyer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'expertise', 'bio', 'license_number', 'verification_status', 'documents', 'latitude', 'longitude', 'city'];

    /** @var array<string,string> */
    protected $casts = [
        'documents' => 'array',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Lawyer> */
    /** @phpstan-ignore-next-line */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Appointment, \App\Models\Lawyer> */
    /** @phpstan-ignore-next-line */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\LawyerCase, \App\Models\Lawyer> */
    /** @phpstan-ignore-next-line */
    public function cases(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LawyerCase::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Analytics, \App\Models\Lawyer> */
    /** @phpstan-ignore-next-line */
    public function analytics(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Analytics::class);
    }
}
