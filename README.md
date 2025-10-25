# LawLite

LawLite is a bilingual (Bangla/English) legal consultation platform connecting verified lawyers with users, providing AI-powered Q&A and document summarization via the Gemini API.

This repository contains scaffolding to build the platform using Laravel, ElasticSearch, and the Gemini API.

Quick start

- Copy `.env.example` to `.env` and fill in database and Gemini API keys.
- Install dependencies: `composer install`
- Generate app key: `php artisan key:generate`
- Run migrations: `php artisan migrate`
- Seed sample data: `php artisan db:seed`
- Serve: `php artisan serve`

Notes

- To enable real-time chat and notifications, add Pusher keys to `.env` (PUSHER_APP_KEY, PUSHER_APP_CLUSTER, PUSHER_APP_SECRET, PUSHER_APP_ID). The layout includes Echo/Pusher client wiring.
- To enable search, run an ElasticSearch instance and set `ELASTICSEARCH_HOST` in `.env`. The project includes a stubbed indexer command in `app/Console/Commands/IndexSearchCommand.php`.

See the `resources` directory for Blade components and `app/Services/GeminiService.php` for the Gemini integration.

Gemini (AI) configuration

The app integrates with a Gemini-compatible AI service. Add these variables to your `.env` or copy from `.env.example`:

```
GEMINI_API_KEY=your_api_key_here
GEMINI_API_URL=https://api.gemini.example/v1
GEMINI_DEFAULT_LANGUAGE=en
GEMINI_TIMEOUT=30
GEMINI_RETRIES=2
```

Notes:

- The `GeminiService` is registered via `App\Providers\GeminiServiceProvider` and injected into `AiController`.
- In local/dev you can leave `GEMINI_API_KEY` empty and stub responses for testing.

Dev quick-switch

There are dev helper routes that allow logging in as seed users (visible only when `APP_ENV=local`):

```
GET /_dev/login-as/admin    -> logs in as admin@example.com
GET /_dev/login-as/lawyer   -> logs in as lawyer@example.com
GET /_dev/login-as/user     -> logs in as user@example.com
```

Remove or disable these routes in production.
