<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\GeminiException;
use App\Services\GeminiService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AiGeminiExceptionTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable CSRF for these tests which intentionally simulate upstream AI failures
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    public function testAskEndpointReturns502WhenGeminiFails()
    {
        // Bind a stub gemini service that throws the GeminiException
        $this->app->bind(GeminiService::class, function () {
            return new class extends \App\Services\GeminiService {
                public function __construct() {}
                public function askQuestion($q, $lang = null)
                {
                    throw new GeminiException('upstream error');
                }
            };
        });

        $response = $this->postJson(route('ai.ask'), ['question' => 'Hello?']);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE']);
        $this->assertTrue($response->headers->has('Retry-After'));
    }

    public function testSummarizeEndpointReturns502WhenGeminiFails()
    {
        $this->app->bind(GeminiService::class, function () {
            return new class extends \App\Services\GeminiService {
                public function __construct() {}
                public function summarize($docs, $lang = null)
                {
                    throw new GeminiException('upstream error');
                }
            };
        });

        $response = $this->postJson(route('ai.summarize'), ['documents' => ['a']]);

        $response->assertStatus(502);
        $response->assertJson(['ok' => false, 'code' => 'AI_SERVICE_UNAVAILABLE']);
        $this->assertTrue($response->headers->has('Retry-After'));
    }
}
