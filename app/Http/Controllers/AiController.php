<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use App\Exceptions\GeminiException;
use App\Models\AiQuery;
use App\Models\AiDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class AiController extends Controller
{
    /** @var \App\Services\GeminiService */
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ask(Request $request): JsonResponse
    {
        /** @var array{question: string, language?: string|null} $data */
        $data = (array) $request->validate([
            'question' => 'required|string',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $question = strval($data['question']);
        $language = $data['language'] ?? 'en';

        try {
            $result = $this->gemini->askQuestion($question, $language);

            // persist to ai_queries table
            try {
                $ai = AiQuery::create([
                    'user_id' => $request->user() ? $request->user()->id : null,
                    'question' => $data['question'],
                    'answer' => json_encode($result),
                    'language' => $language,
                    'metadata' => null,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save AI query: ' . $e->getMessage());
            }

            return new JsonResponse(['ok' => true, 'result' => $result['answer'] ?? $result]);
        } catch (GeminiException $e) {
            Log::error('Gemini API error: ' . $e->getMessage());

            $retryAfter = $e->getRetryAfter() ?? 30;
            $payload = [
                'ok' => false,
                'error' => 'AI service unavailable. Please try again later.',
                'code' => 'AI_SERVICE_UNAVAILABLE',
                'retry_after' => $retryAfter
            ];

            if (($attempts = $e->getAttempts()) !== null) {
                $payload['attempts'] = $attempts;
            }

            return new JsonResponse($payload, 502, ['Retry-After' => (string)$retryAfter]);
        } catch (\Exception $e) {
            Log::error('Unexpected error in AI controller: ' . $e->getMessage());
            return new JsonResponse(['ok' => false, 'error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function summarize(Request $request): JsonResponse
    {
        $data = (array) $request->validate([
            'documents' => 'required|array',
            'language' => 'nullable|string|in:en,bn',
        ]);

        /** @var array{documents: array<int, array<string, mixed>|string>, language?: string|null} $data */
        $data = (array) $request->validate([
            'documents' => 'required|array',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';
        $documentsRaw = $data['documents'];
        $documents = array_map(function ($d) {
            return is_array($d) ? $d : strval($d);
        }, $documentsRaw);

        try {
            /** @var array<int, array<string, mixed>|string> $documents */
            $result = $this->gemini->summarize($documents, $language);

            // store in ai_documents
            try {
                $doc = AiDocument::create([
                    'user_id' => $request->user() ? $request->user()->id : null,
                    'document_path' => 'uploaded/documents/placeholder',
                    'summary_text' => is_array($result) ? json_encode($result) : (string) $result,
                    'language' => $language,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save AI document summary: ' . $e->getMessage());
            }

            return new JsonResponse(['ok' => true, 'result' => $result]);
        } catch (GeminiException $e) {
            Log::error('Gemini API error: ' . $e->getMessage());

            $retryAfter = $e->getRetryAfter() ?? 30;
            $payload = [
                'ok' => false,
                'error' => 'AI service unavailable. Please try again later.',
                'code' => 'AI_SERVICE_UNAVAILABLE',
                'retry_after' => $retryAfter
            ];

            if (($attempts = $e->getAttempts()) !== null) {
                $payload['attempts'] = $attempts;
            }

            return new JsonResponse($payload, 502, ['Retry-After' => (string)$retryAfter]);
        } catch (\Exception $e) {
            Log::error('Unexpected error in AI controller: ' . $e->getMessage());
            return new JsonResponse(['ok' => false, 'error' => 'An unexpected error occurred.'], 500);
        }
    }
}
