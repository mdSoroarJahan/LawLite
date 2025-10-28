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

    public function lawyer()
    {
        return $this->hasOne(Lawyer::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function aiQueries()
    {
        return $this->hasMany(AiQuery::class);
    }

    public function aiDocuments()
    {
        return $this->hasMany(AiDocument::class);
    }
}
