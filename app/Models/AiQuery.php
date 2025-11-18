<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AiQuery
 *
 * @property int $id
 * @property int $user_id
 * @property string $question
 * @property string|null $answer
 * @property string|null $language
 * @property array<string,mixed>|null $metadata
 * @method static \Database\Factories\AiQueryFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AiQueryFactory>
 */
class AiQuery extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question', 'answer', 'language', 'metadata'];

    /** @var array<string,string> */
    protected $casts = [
        'metadata' => 'array',
    ];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\AiQuery> */
    /** @phpstan-ignore-next-line */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
