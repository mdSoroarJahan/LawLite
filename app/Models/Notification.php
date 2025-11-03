<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\NotificationFactory>
 */
class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'message', 'read_status'];

    /** @phpstan-ignore-next-line */
    /** @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Notification> */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
