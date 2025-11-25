<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $content
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\User|null $sender
 * @property-read \App\Models\User|null $receiver
 * @method static \Database\Factories\MessageFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\MessageFactory>
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'content', 'is_read', 'attachment_path', 'attachment_type'];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Message> */
    /** @phpstan-ignore-next-line */
    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Message> */
    /** @phpstan-ignore-next-line */
    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
