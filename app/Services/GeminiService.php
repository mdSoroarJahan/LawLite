<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Exceptions\GeminiException;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Services\Metrics;

class GeminiService
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl;
    protected int $timeout;
    protected int $retries;

    public function __construct(Client $client = null)
    {
        // Prefer reading from config() at runtime. Environment variables should be
        // consumed in config files (config/gemini.php) so the values work when the
        // config is cached. Provide safe defaults here.
        $cfg = config('gemini.api_key', '');
        if (!is_scalar($cfg) && $cfg !== null) {
            $cfg = '';
        }
        $this->apiKey = strval($cfg);

        $cfg = config('gemini.base_url', 'https://api.gemini.example/v1');
        if (!is_scalar($cfg) && $cfg !== null) {
            $cfg = 'https://api.gemini.example/v1';
        }
        $this->baseUrl = strval($cfg);

        $cfg = config('gemini.timeout', 30);
        if (!is_scalar($cfg) && $cfg !== null) {
            $cfg = 30;
        }
        $this->timeout = intval($cfg);

        $cfg = config('gemini.retries', 2);
        if (!is_scalar($cfg) && $cfg !== null) {
            $cfg = 2;
        }
        $this->retries = intval($cfg);

        // Ensure base_uri ends with / for proper Guzzle path joining
        $baseUri = rtrim($this->baseUrl, '/') . '/';
        $this->client = $client ?? new Client(['base_uri' => $baseUri, 'timeout' => $this->timeout]);
    }

    /**
     * Ask a question to the Gemini AI and return decoded JSON (array) or null on no-body.
     *
     * @param string $question
     * @param string|null $language
     * @return array<string,mixed>|null
     * @throws GeminiException
     */
    public function askQuestion(string $question, ?string $language = null): ?array
    {
        $language = $language ?? config('gemini.default_language', 'en');

        // Build the prompt with language preference
        $prompt = $language === 'bn'
            ? "আপনি একজন বাংলাদেশী আইন বিশেষজ্ঞ। নিম্নলিখিত প্রশ্নের উত্তর দিন:\n\n{$question}"
            : "You are a legal expert in Bangladesh law. Answer the following question concisely:\n\n{$question}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        // Use gemini-flash-latest on the v1beta endpoint (current stable model)
        $fullUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$this->apiKey}";
        $response = $this->request('POST', $fullUrl, [
            'json' => $payload,
        ]);

        // Extract text from Google's response format
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return ['answer' => $response['candidates'][0]['content']['parts'][0]['text']];
        }

        return $response;
    }

    /**
     * Summarize documents via Gemini.
     *
     * @param array<int,string|array<string,mixed>> $documentFiles
     * @param string|null $language
     * @return array<string,mixed>|null
     * @throws GeminiException
     */
    public function summarize(array $documentFiles, ?string $language = null): ?array
    {
        $language = $language ?? config('gemini.default_language', 'bn');

        $payload = [
            'documents' => $documentFiles,
            'language' => $language,
        ];

        return $this->request('POST', '/summarize', [
            'json' => $payload,
        ]);
    }

    /**
     * Perform an HTTP request with retries and error handling.
     * Returns decoded JSON array on success, or throws exception on failure.
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array|null
     * @throws \Exception
     */
    /**
     * Perform an HTTP request with retries and error handling.
     * Returns decoded JSON array on success, or throws GeminiException on failure.
     *
     * @param string $method
     * @param string $uri
     * @param array<string,mixed> $options
     * @return array<string,mixed>|null
     * @throws GeminiException
     */
    protected function request(string $method, string $uri, array $options = []): ?array
    {
        $attempts = 0;
        $lastEx = null;

        // prepare headers (Google Gemini uses API key in URL, not Authorization header)
        $headers = (array) Arr::get($options, 'headers', []);
        $headers = array_merge($headers, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $options['headers'] = $headers;

        while ($attempts <= $this->retries) {
            try {
                $attempts++;
                /** @var ResponseInterface $resp */
                $resp = $this->client->request($method, $uri, $options);
                $body = $resp->getBody()->getContents();
                /** @var array<string,mixed>|null $decoded */
                $decoded = json_decode($body, true);
                if (is_array($decoded)) {
                    /** @var array<string,mixed> $decoded */
                    return $decoded;
                }
                return ['raw' => strval($body)];
            } catch (GuzzleException $e) {
                $lastEx = $e;

                // If upstream says quota exceeded, stop retrying and bubble a clear error
                $statusCode = method_exists($e, 'getCode') ? (int) $e->getCode() : 0;
                $response = method_exists($e, 'getResponse') ? $e->getResponse() : null;
                $retryAfterHeader = $response && $response->hasHeader('Retry-After')
                    ? (int) $response->getHeaderLine('Retry-After')
                    : null;
                if ($statusCode === 429) {
                    $retryCfg = config('gemini.retry_after', 30);
                    if (!is_scalar($retryCfg) && $retryCfg !== null) {
                        $retryCfg = 30;
                    }
                    $retryAfter = $retryAfterHeader ?? (int) $retryCfg;
                    throw new GeminiException(
                        'Gemini quota exceeded (429). Please update API key or billing.',
                        $statusCode,
                        $e,
                        $attempts,
                        $retryAfter
                    );
                }

                // log the failed attempt so we can monitor retries
                Log::warning('GeminiService request failed (GuzzleException)', [
                    'method' => $method,
                    'uri' => $uri,
                    'attempt' => $attempts,
                    'error' => $e->getMessage(),
                ]);
                // increment retry attempt metric (best-effort)
                Metrics::increment('gemini.retry.attempts');
                // simple backoff
                if ($attempts > $this->retries) {
                    break;
                }
                usleep(100000 * $attempts); // 100ms * attempts
                continue;
            } catch (\Throwable $t) {
                $lastEx = $t;
                Log::error('GeminiService unexpected error', [
                    'method' => $method,
                    'uri' => $uri,
                    'attempt' => $attempts,
                    'error' => $t->getMessage(),
                ]);
                break;
            }
        }

        $lastExMessage = $lastEx instanceof \Throwable ? $lastEx->getMessage() : 'unknown';
        $msg = sprintf('GeminiService request failed after %d attempts: %s', $attempts, $lastExMessage);
        // Attach retry_after value (suggested) to the exception message for downstream handling if needed
        $retryCfg = config('gemini.retry_after', 30);
        if (!is_scalar($retryCfg) && $retryCfg !== null) {
            $retryCfg = 30;
        }
        $retryAfter = intval($retryCfg);
        $msg = $msg . sprintf(' (retry_after=%d)', $retryAfter);
        // increment final failure metric
        Metrics::increment('gemini.retry.final_failures');
        throw new GeminiException($msg, 0, $lastEx, $attempts, $retryAfter);
    }

    /**
     * Analyze a document (PDF) with Gemini AI
     *
     * @param string $base64Content Base64 encoded document content
     * @param string $prompt The analysis prompt
     * @param string|null $language Language preference
     * @param string $mimeType MIME type of the document
     * @return array<string,mixed>|null
     * @throws GeminiException
     */
    public function analyzeDocument(string $base64Content, string $prompt, ?string $language = null, string $mimeType = 'application/pdf'): ?array
    {
        $language = $language ?? config('gemini.default_language', 'bn');

        // Build payload with inline document data for Gemini
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => $base64Content
                            ]
                        ],
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.4,
                'topK' => 32,
                'topP' => 1,
                'maxOutputTokens' => 8192,
            ]
        ];

        // Use gemini-flash-latest on the v1beta endpoint for document analysis
        $fullUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$this->apiKey}";
        
        $response = $this->request('POST', $fullUrl, [
            'json' => $payload,
        ]);

        // Extract text from Google's response format
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return ['answer' => $response['candidates'][0]['content']['parts'][0]['text']];
        }

        return $response;
    }
}
