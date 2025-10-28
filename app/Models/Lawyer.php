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
 * @property array|null $documents
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $city
 */
class Lawyer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'expertise', 'bio', 'license_number', 'verification_status', 'documents', 'latitude', 'longitude', 'city'];

    protected $casts = [
        'documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function analytics()
    {
        return $this->hasOne(Analytics::class);
    }
}
