<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\GeminiService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class GeminiServiceTest extends TestCase
{
    public function testAskQuestionReturnsDecodedJson(): void
    {
        $body = (string) json_encode(['answer' => 'Hello from Gemini']);
        $response = new Response(200, ['Content-Type' => 'application/json'], $body);

        $mockClient = $this->createMock(Client::class);
        $mockClient->method('request')->willReturn($response);

        $svc = new GeminiService($mockClient);
        $result = $svc->askQuestion('What is law?');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('answer', $result);
        $this->assertEquals('Hello from Gemini', $result['answer']);
    }
}
