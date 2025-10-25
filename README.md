# LawLite

LawLite is a bilingual (Bangla / English) legal consultation and knowledge-sharing platform scaffolded with Laravel 10.

## AI error response contract

When the upstream AI service (Gemini) is unavailable the application returns HTTP 502 with a structured JSON payload and a `Retry-After` header to help clients handle retries gracefully.

Example response:

```http
HTTP/1.1 502 Bad Gateway
Retry-After: 30

{
  "ok": false,
  "error": "AI service unavailable. Please try again later.",
  "code": "AI_SERVICE_UNAVAILABLE",
  "retry_after": 30
}
```

- `code` is a machine-friendly error identifier.
- `retry_after` (seconds) is present in both the JSON body and the `Retry-After` header.

Clients should respect `Retry-After` and avoid tight retry loops. Treat `AI_SERVICE_UNAVAILABLE` as transient.

## Metrics (optional)

This project includes a minimal StatsD-style metrics emitter. Metrics are disabled by default. To enable metrics, set the following in your `.env`:

```env
METRICS_ENABLED=true
METRICS_HOST=127.0.0.1
METRICS_PORT=8125
METRICS_PREFIX=lawlite.dev
```

When enabled the `GeminiService` emits two counters:

- `gemini.retry.attempts`  incremented on each retry attempt.
- `gemini.retry.final_failures`  incremented when all retries fail.

The implementation is best-effort (UDP) and will not throw on failures to send metrics.

Advanced options

- `METRICS_USE_CLIENT` (boolean) — when true, the app will attempt to use a maintained StatsD client library (domnikl/statsd by default) to send metrics over UDP. If the client is unavailable or fails, the code falls back to the simple UDP sender. Default: `false`.
- `METRICS_TESTING_SPY` (boolean) — test-only helper. When enabled in tests the `Metrics` service writes emitted metric names to `storage/logs/metrics_test.log` so unit tests can assert metrics were emitted without requiring a running metrics backend. Default: `false`.

Note: the project currently includes optional support for `domnikl/statsd`. The package is small and functional; if you prefer a different client (for example `slickdeals/statsd`) we can swap it — the `Metrics` service is implemented to allow a client or fall back to UDP.

## Running tests

Locally (Windows PowerShell):

```powershell
composer install
vendor\\bin\\phpunit
```

CI: The repository contains `.github/workflows/phpunit.yml` which runs PHPUnit on push and pull requests to `main`.

## Quick start

1. Copy `.env.example` to `.env` and set DB and Gemini API variables.
2. Install dependencies: `composer install`
3. Generate app key: `php artisan key:generate`
4. Run migrations: `php artisan migrate`
5. Seed sample data: `php artisan db:seed`
6. Serve locally: `php artisan serve`

## Developer notes

- Gemini config: `config/gemini.php`  set `GEMINI_API_KEY`, `GEMINI_RETRY_AFTER`, etc.
- `app/Services/GeminiService.php` contains retry logic, logging, and metrics emission.
- `app/Exceptions/Handler.php` renders `GeminiException` as 502 with `retry_after` (and `attempts` when available).

## Dev & Ops notes

- For real-time features add Pusher/Echo keys to `.env` (PUSHER_* variables).
- To enable search, provide an ElasticSearch host in `.env` (ELASTICSEARCH_HOST).
- The `GeminiService` is registered via `App\\Providers\\GeminiServiceProvider` and injected into controllers that need AI features.
