<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
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

        // Render GeminiException as a 502 JSON response for API requests.
        // Wrap rendering in a try/catch to avoid converting rendering errors into 500 responses
        // (for example if logging or a header operation unexpectedly throws in CI).
        $this->renderable(function (GeminiException $e, Request $request) {
            try {
                // Prefer the retry-after and attempts values carried by the exception when set,
                // otherwise fall back to config defaults.
                $retryCfg = $e->getRetryAfter() ?? config('gemini.retry_after', 30);
                if (!is_scalar($retryCfg) && $retryCfg !== null) {
                    $retryCfg = 30;
                }
                $retryAfter = intval($retryCfg);
                /** @var int $retryAfter */
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
                    return new JsonResponse($payload, 502, ['Retry-After' => strval($retryAfter)]);
                }

                // For non-JSON requests fall back to a simple response with 502 and Retry-After header
                $body = 'AI service unavailable. Please try again later.';
                if ($attempts !== null) {
                    $body .= " (attempts={$attempts})";
                }

                $resp = new \Illuminate\Http\Response($body, 502);
                $resp->header('Retry-After', strval($retryAfter));
                return $resp;
            } catch (\Throwable $renderEx) {
                // If rendering the GeminiException fails (e.g., logger misconfiguration),
                // log the rendering error and return a minimal safe 502 response so tests
                // and clients get the correct status instead of a 500.
                try {
                    Log::error('Failed while rendering GeminiException response', [
                        'render_error' => $renderEx->getMessage(),
                        'original_error' => $e->getMessage(),
                        'path' => $request->path(),
                    ]);
                } catch (\Throwable $_) {
                    // best-effort logging; swallow to avoid further exceptions
                }
                $retryCfg = config('gemini.retry_after', 30);
                if (!is_scalar($retryCfg) && $retryCfg !== null) {
                    $retryCfg = 30;
                }
                $retryAfter = intval($retryCfg);
                /** @var int $retryAfter */
                $payload = [
                    'ok' => false,
                    'error' => 'AI service unavailable. Please try again later.',
                    'code' => 'AI_SERVICE_UNAVAILABLE',
                    'retry_after' => $retryAfter,
                ];

                return new JsonResponse($payload, 502, ['Retry-After' => strval($retryAfter)]);
            }
        });
    }

    /**
     * Defensive render fallback: ensure GeminiException always returns
     * a minimal 502 JSON response even if other rendering paths fail.
     *
     * This complements the renderable callback and protects CI/tests
     * from unexpected 500s caused by logging or header operations.
     */
    public function render($request, Throwable $e)
    {
        try {
            if ($e instanceof GeminiException) {
                $retryCfg = $e->getRetryAfter() ?? config('gemini.retry_after', 30);
                if (!is_scalar($retryCfg) && $retryCfg !== null) {
                    $retryCfg = 30;
                }
                $retryAfter = intval($retryCfg);
                /** @var int $retryAfter */
                $payload = [
                    'ok' => false,
                    'error' => 'AI service unavailable. Please try again later.',
                    'code' => 'AI_SERVICE_UNAVAILABLE',
                    'retry_after' => $retryAfter,
                ];

                if (($attempts = $e->getAttempts()) !== null) {
                    $payload['attempts'] = $attempts;
                }

                return new JsonResponse($payload, 502, ['Retry-After' => strval($retryAfter)]);
            }
        } catch (Throwable $_) {
            // swallow any errors here to avoid turning this into a 500
        }

        return parent::render($request, $e);
    }
}
