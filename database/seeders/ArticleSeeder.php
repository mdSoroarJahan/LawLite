<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $author = User::where('role', 'admin')->first();

        Article::create([
            'title' => 'Understanding Family Law in Bangladesh',
            'content' => 'This article explains the basics of family law in Bangladeshi context... (sample)',
            'author_id' => $author ? $author->id : null,
            'language' => 'bn',
            'published_at' => now(),
        ]);
    }
}
