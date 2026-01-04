<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App as LaravelApp;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(): void
    {
        // Read locale from session (set by language switch route) and apply it
        try {
            $locale = Session::get('locale', config('app.locale'));
            if ($locale) {
                LaravelApp::setLocale($locale);
            }
        } catch (\Throwable $e) {
            // Ignore if session not available during certain CLI tasks
        }
    }
}
