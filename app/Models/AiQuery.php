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
 * @property array|null $metadata
 */
class AiQuery extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question', 'answer', 'language', 'metadata'];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
