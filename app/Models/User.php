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
        'location'
    ];

    protected $hidden = ['password'];

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne */
    public function lawyer()
    {
        return $this->hasOne(Lawyer::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function aiQueries()
    {
        return $this->hasMany(AiQuery::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function aiDocuments()
    {
        return $this->hasMany(AiDocument::class);
    }
}
