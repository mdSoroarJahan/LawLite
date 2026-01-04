<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $password
 * @property string $role
 * @property string|null $language_preference
 * @property string|null $location
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $last_seen_at
 * @property-read \App\Models\Lawyer|null $lawyer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messagesSent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messagesReceived
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AiQuery> $aiQueries
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AiDocument> $aiDocuments
 * @method static \Illuminate\Database\Eloquent\Builder<\App\Models\User> whereIn(string $column, array<int,mixed> $values)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\UserFactory>
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'language_preference',
        'location',
        'profile_photo_path',
        'last_seen_at'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Lawyer, \App\Models\User> */
    /** @phpstan-ignore-next-line */
    public function lawyer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Lawyer::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Message, \App\Models\User> */
    /** @phpstan-ignore-next-line */
    public function messagesSent(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Message, \App\Models\User> */
    /** @phpstan-ignore-next-line */
    public function messagesReceived(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Appointment, \App\Models\User> */
    /** @phpstan-ignore-next-line */
    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\AiQuery, \App\Models\User> */
    /** @phpstan-ignore-next-line */
    public function aiQueries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AiQuery::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\AiDocument, \App\Models\User> */
    /** @phpstan-ignore-next-line */
    public function aiDocuments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AiDocument::class);
    }

    public function isOnline(): bool
    {
        return \Illuminate\Support\Facades\Cache::has('user-is-online-' . $this->id);
    }
}
