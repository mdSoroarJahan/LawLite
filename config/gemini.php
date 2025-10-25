<?php

return [
    // API key for Gemini (fall back to env)
    'api_key' => env('GEMINI_API_KEY', null),
    // Base API URL
    'base_url' => env('GEMINI_API_URL', 'https://api.gemini.example/v1'),
    // Default language for chat/summarize
    'default_language' => env('GEMINI_DEFAULT_LANGUAGE', 'en'),
    // HTTP client timeout in seconds
    'timeout' => env('GEMINI_TIMEOUT', 30),
    // Number of retries for transient errors
    'retries' => env('GEMINI_RETRIES', 2),
    // Retry-After seconds suggested to clients when upstream AI is unavailable
    'retry_after' => env('GEMINI_RETRY_AFTER', 30),
];
