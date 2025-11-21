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

        $this->client = $client ?? new Client(['base_uri' => $this->baseUrl, 'timeout' => $this->timeout]);
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

        $response = $this->request('POST', "/models/gemini-pro:generateContent?key={$this->apiKey}", [
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
}
