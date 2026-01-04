<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\GeminiException;
use App\Services\GeminiService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AiGeminiExceptionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAskEndpointReturns502WhenGeminiFails(): void
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

        // Authenticate and include CSRF token so middleware is exercised
        $user = new \App\Models\User(['id' => 1001, 'name' => 'Test User', 'email' => 'testuser@example']);
        $this->actingAs($user);
        $this->withSession(['_token' => 'test-csrf-token']);
        $response = $this->withHeaders(['X-CSRF-TOKEN' => 'test-csrf-token'])
            ->postJson(route('ai.ask'), ['question' => 'Hello?']);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE']);
        $this->assertTrue($response->headers->has('Retry-After'));
    }

    public function testSummarizeEndpointReturns502WhenGeminiFails(): void
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

        // Authenticate and include CSRF token so middleware is exercised
        $user = new \App\Models\User(['id' => 1002, 'name' => 'Test User 2', 'email' => 'testuser2@example']);
        $this->actingAs($user);
        $this->withSession(['_token' => 'test-csrf-token']);
        $response = $this->withHeaders(['X-CSRF-TOKEN' => 'test-csrf-token'])
            ->postJson(route('ai.summarize'), ['documents' => ['a']]);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE']);
        $this->assertTrue($response->headers->has('Retry-After'));
    }
}
