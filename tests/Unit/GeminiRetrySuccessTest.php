<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\Services\GeminiService;

class GeminiRetrySuccessTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        config(['metrics.testing_spy' => true]);
        config(['gemini.retries' => 2]);
        $p = storage_path('logs/metrics_test.log');
        if (file_exists($p)) {
            @unlink($p);
        }
    }

    public function tearDown(): void
    {
        $p = storage_path('logs/metrics_test.log');
        if (file_exists($p)) {
            @unlink($p);
        }
        parent::tearDown();
    }

    public function test_gemini_service_retries_and_succeeds(): void
    {
        // Prepare a client mock that fails once then succeeds
        $exception = new RequestException('network error', new GuzzleRequest('POST', '/'));
        $body = json_encode(['answer' => 'recovered']);
        $success = new GuzzleResponse(200, ['Content-Type' => 'application/json'], (string) $body);

        $client = $this->getMockBuilder(\GuzzleHttp\Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $invocation = 0;

        $client->method('request')
            ->willReturnCallback(function () use (&$invocation, $exception, $success) {
                $invocation++;
                if ($invocation === 1) {
                    throw $exception;
                }

                return $success;
            });

        $svc = new GeminiService($client);

        $result = $svc->askQuestion('Will it retry?');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('answer', $result);
        $this->assertEquals('recovered', $result['answer']);

        // Ensure metrics spy logged at least one retry attempt
        $p = storage_path('logs/metrics_test.log');
        $this->assertFileExists($p);
        $contents = implode('\n', array_map(function ($s) {
            return trim((string) $s);
        }, (array) file($p)));
        $this->assertStringContainsString('gemini.retry.attempts', $contents);
    }
}
