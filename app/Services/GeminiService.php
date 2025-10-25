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
    protected $client;
    protected $apiKey;
    protected $baseUrl;
    protected $timeout;
    protected $retries;

    public function __construct(Client $client = null)
    {
        $this->apiKey = config('gemini.api_key', env('GEMINI_API_KEY'));
        $this->baseUrl = config('gemini.base_url', env('GEMINI_API_URL', 'https://api.gemini.example/v1'));
        $this->timeout = config('gemini.timeout', 30);
        $this->retries = config('gemini.retries', 2);

        $this->client = $client ?? new Client(['base_uri' => $this->baseUrl, 'timeout' => $this->timeout]);
    }

    public function askQuestion(string $question, string $language = null)
    {
        $language = $language ?? config('gemini.default_language', 'en');

        $payload = [
            'question' => $question,
            'language' => $language,
        ];

        $response = $this->request('POST', '/ask', [
            'json' => $payload,
        ]);

        return $response;
    }

    public function summarize(array $documentFiles, string $language = null)
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
    protected function request(string $method, string $uri, array $options = [])
    {
        $attempts = 0;
        $lastEx = null;

        // prepare headers including Authorization
        $headers = Arr::get($options, 'headers', []);
        $headers = array_merge($headers, [
            'Authorization' => 'Bearer ' . $this->apiKey,
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
                $decoded = json_decode($body, true);
                return $decoded === null ? ['raw' => $body] : $decoded;
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

        $msg = sprintf('GeminiService request failed after %d attempts: %s', $attempts, ($lastEx ? $lastEx->getMessage() : 'unknown'));
        // Attach retry_after value (suggested) to the exception message for downstream handling if needed
        $retryAfter = config('gemini.retry_after', 30);
        $msg = $msg . sprintf(' (retry_after=%d)', $retryAfter);
        // increment final failure metric
        Metrics::increment('gemini.retry.final_failures');
        throw new GeminiException($msg, 0, $lastEx, $attempts, $retryAfter);
    }
}
