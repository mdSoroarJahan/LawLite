<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\GeminiException;
use App\Services\GeminiService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AiGeminiMetadataIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function testAskEndpointReturnsExceptionMetadata(): void
    {
        // Bind stub that throws GeminiException with metadata
        $this->app->bind(GeminiService::class, function () {
            return new class extends \App\Services\GeminiService {
                public function __construct() {}
                public function askQuestion(string $q, ?string $lang = null): ?array
                {
                    throw new GeminiException('upstream error', 0, null, 3, 45);
                }
            };
        });

        $user = new User(['id' => 9001, 'name' => 'Meta Tester', 'email' => 'meta@test.example']);
        $this->actingAs($user);
        $this->withSession(['_token' => 'meta-csrf-token']);

        $response = $this->withHeaders(['X-CSRF-TOKEN' => 'meta-csrf-token'])
            ->postJson(route('ai.ask'), ['question' => 'Metadata?']);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE', 'retry_after' => 45, 'attempts' => 3]);
        $this->assertEquals('45', $response->headers->get('Retry-After'));
    }

    public function testSummarizeEndpointReturnsExceptionMetadata(): void
    {
        $this->app->bind(GeminiService::class, function () {
            return new class extends \App\Services\GeminiService {
                public function __construct() {}
                public function summarize(array $docs, ?string $lang = null): ?array
                {
                    throw new GeminiException('upstream error', 0, null, 3, 45);
                }
            };
        });

        $user = new User(['id' => 9002, 'name' => 'Meta Tester 2', 'email' => 'meta2@test.example']);
        $this->actingAs($user);
        $this->withSession(['_token' => 'meta-csrf-token']);

        $response = $this->withHeaders(['X-CSRF-TOKEN' => 'meta-csrf-token'])
            ->postJson(route('ai.summarize'), ['documents' => ['x']]);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE', 'retry_after' => 45, 'attempts' => 3]);
        $this->assertEquals('45', $response->headers->get('Retry-After'));
    }
}
