<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use App\Services\GeminiService;

class GeminiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(GeminiService::class, function ($app) {
            $base = config('gemini.base_url');
            $timeout = config('gemini.timeout', 30);

            $client = new Client([
                'base_uri' => $base,
                'timeout' => $timeout,
            ]);

            return new GeminiService($client);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // no-op
    }
}
