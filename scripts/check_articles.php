<?php

use App\Models\Article;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$articles = Article::all();

echo "Total Articles: " . $articles->count() . "\n";
foreach ($articles as $article) {
    echo "ID: {$article->id} - Title: {$article->title}\n";
}
