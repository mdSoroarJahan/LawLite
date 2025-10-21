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
