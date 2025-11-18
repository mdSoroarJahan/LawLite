<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AiDocument
 *
 * @property int $id
 * @property int $user_id
 * @property string $document_path
 * @property string|null $summary_text
 * @property string|null $language
 * @method static \Database\Factories\AiDocumentFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\AiDocumentFactory>
 */
class AiDocument extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'document_path', 'summary_text', 'language'];

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\AiDocument> */
    /** @phpstan-ignore-next-line */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
