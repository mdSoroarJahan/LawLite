<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\GeminiException;
use App\Services\GeminiService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AiGeminiIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function testAskEndpointWithAuthReturns502WhenGeminiFails(): void
    {
        // Bind a stub gemini service that throws the GeminiException
        $this->app->bind(GeminiService::class, function () {
            return new class extends \App\Services\GeminiService {
                public function __construct() {}
                public function askQuestion(string $q, ?string $lang = null): ?array
                {
                    throw new GeminiException('upstream error');
                }
            };
        });

        // Create an in-memory user instance and authenticate
        $user = new User(['id' => 9999, 'name' => 'Integration Tester', 'email' => 'int@test.example']);
        $this->actingAs($user);

        // Ensure session has a CSRF token and include it in the request headers
        $this->withSession(['_token' => 'test-csrf-token']);
        $response = $this->withHeaders(['X-CSRF-TOKEN' => 'test-csrf-token'])
            ->postJson(route('ai.ask'), ['question' => 'Hello?']);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE']);
        $this->assertTrue($response->headers->has('Retry-After'));
    }

    public function testSummarizeEndpointWithAuthReturns502WhenGeminiFails(): void
    {
        $this->app->bind(GeminiService::class, function () {
            return new class extends \App\Services\GeminiService {
                public function __construct() {}
                public function summarize(array $docs, ?string $lang = null): ?array
                {
                    throw new GeminiException('upstream error');
                }
            };
        });

        $user = new User(['id' => 9998, 'name' => 'Integration Tester 2', 'email' => 'int2@test.example']);
        $this->actingAs($user);

        // Ensure session has a CSRF token and include it in the request headers
        $this->withSession(['_token' => 'test-csrf-token']);
        $response = $this->withHeaders(['X-CSRF-TOKEN' => 'test-csrf-token'])
            ->postJson(route('ai.summarize'), ['documents' => ['a']]);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE']);
        $this->assertTrue($response->headers->has('Retry-After'));
    }
}
