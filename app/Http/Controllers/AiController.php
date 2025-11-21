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

            // Temporary: return a mock response for demonstration
            $mockAnswer = "In Bangladesh, divorce can be obtained through several legal procedures:\n\n1. **Talaq (Muslim Law)**: Husband can divorce by pronouncing talaq three times\n2. **Khula**: Wife-initiated divorce requiring husband's consent or court intervention\n3. **Judicial Divorce**: Either spouse can file under the Dissolution of Muslim Marriages Act 1939\n\nKey grounds include:\n- Cruelty or desertion\n- Failure to maintain\n- Impotence\n- Insanity\n\nYou should consult a qualified family law attorney for your specific situation.";

            return new JsonResponse(['ok' => true, 'result' => $mockAnswer]);
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
    }
}
