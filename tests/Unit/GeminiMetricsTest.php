<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\Services\GeminiService;

class GeminiMetricsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Enable metrics spy
        config(['metrics.testing_spy' => true]);
        // Ensure no stale file
        $path = storage_path('logs/metrics_test.log');
        if (file_exists($path)) {
            @unlink($path);
        }
        // Keep retries small to make the test fast
        config(['gemini.retries' => 1]);
    }

    public function tearDown(): void
    {
        // Cleanup spy file
        $path = storage_path('logs/metrics_test.log');
        if (file_exists($path)) {
            @unlink($path);
        }
        parent::tearDown();
    }

    public function test_gemini_service_emits_retry_and_final_failure_metrics(): void
    {
        // Create a Guzzle client mock that always throws a RequestException
        $client = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client->method('request')
            ->will($this->throwException(new RequestException('request failed', new GuzzleRequest('POST', '/'))));

        $service = new GeminiService($client);

        $this->expectException(\App\Exceptions\GeminiException::class);

        try {
            $service->askQuestion('Will this trigger metrics?');
        } finally {
            $path = storage_path('logs/metrics_test.log');
            $this->assertFileExists($path, 'Expected metrics spy log to exist');
            $lines = array_filter(array_map(function ($s) {
                return trim((string) $s);
            }, (array) file($path)));
            // Expect two retry attempts (attempts metric) and one final failure
            $attempts = 0;
            $finals = 0;
            foreach ($lines as $l) {
                if (stripos($l, 'gemini.retry.attempts') !== false) {
                    $attempts++;
                }
                if (stripos($l, 'gemini.retry.final_failures') !== false) {
                    $finals++;
                }
            }

            $this->assertGreaterThanOrEqual(2, $attempts, 'Expected at least 2 retry attempt metric entries');
            $this->assertGreaterThanOrEqual(1, $finals, 'Expected at least 1 final failure metric entry');
        }
    }
}
