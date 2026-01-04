<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lawyer;
use App\Models\Article;

class IndexSearchCommand extends Command
{
    protected $signature = 'search:reindex';
    protected $description = 'Reindex lawyers and articles into ElasticSearch';

    public function handle(): int
    {
        $this->info('Starting reindex...');

        // Placeholder: connect to Elastic client and index documents.
        // In production, use elasticsearch/elasticsearch PHP client.

        $lawyers = Lawyer::with('user')->get();
        foreach ($lawyers as $lawyer) {
            /** @var \App\Models\Lawyer $lawyer */
            // build index document
            $doc = [
                'id' => $lawyer->id,
                'name' => $lawyer->user->name ?? null,
                'expertise' => $lawyer->expertise,
                'city' => $lawyer->city,
                'location' => [$lawyer->latitude, $lawyer->longitude],
            ];
            // TODO: index $doc into ES
        }

        $articles = Article::all();
        foreach ($articles as $article) {
            /** @var \App\Models\Article $article */
            $doc = [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'language' => $article->language,
            ];
            // TODO: index $doc into ES
        }

        $this->info('Reindex completed (placeholder).');
        return 0;
    }
}
