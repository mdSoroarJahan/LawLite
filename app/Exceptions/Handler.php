<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\GeminiException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // default reporting
        });

        // Render GeminiException as a 502 JSON response for API requests
        $this->renderable(function (GeminiException $e, $request) {
            // Prefer the retry-after and attempts values carried by the exception when set,
            // otherwise fall back to config defaults.
            $retryAfter = $e->getRetryAfter() ?? config('gemini.retry_after', 30);
            $attempts = $e->getAttempts() ?? null;

            // Structured payload that clients can use for programmatic retries
            $payload = [
                'ok' => false,
                'error' => 'AI service unavailable. Please try again later.',
                'code' => 'AI_SERVICE_UNAVAILABLE',
                'retry_after' => $retryAfter,
            ];

            if ($attempts !== null) {
                $payload['attempts'] = $attempts;
            }

            // Structured logging for observability: include retry_after and attempts when available
            Log::warning('Rendering GeminiException response', [
                'retry_after' => $retryAfter,
                'attempts' => $attempts,
                'message' => $e->getMessage(),
                'path' => $request->path(),
            ]);

            // If the client expects JSON, return a structured JSON response with Retry-After header
            if ($request->expectsJson() || $request->is('api/*') || $request->wantsJson()) {
                // Return a concrete JsonResponse so static analysis can resolve methods
                return new JsonResponse($payload, 502, ['Retry-After' => (string) $retryAfter]);
            }

            // For non-JSON requests fall back to a simple response with 502 and Retry-After header
            $body = 'AI service unavailable. Please try again later.';
            if ($attempts !== null) {
                $body .= " (attempts={$attempts})";
            }

            $resp = new \Illuminate\Http\Response($body, 502);
            $resp->header('Retry-After', (string) $retryAfter);
            return $resp;
        });
    }
}
