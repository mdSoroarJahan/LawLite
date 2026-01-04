<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @method static \Database\Factories\ArticleFactory factory(...$parameters)
 * @phpstan-use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ArticleFactory>
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'author_id', 'language', 'published_at', 'status'];

    /** @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Article> */
    /** @phpstan-ignore-next-line */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
