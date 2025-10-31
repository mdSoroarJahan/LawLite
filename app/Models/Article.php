<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $author_id
 * @property string $language
 */
/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\ArticleFactory>
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'author_id', 'language', 'published_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Article>
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
