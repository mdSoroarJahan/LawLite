<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use App\Exceptions\GeminiException;
use App\Models\AiQuery;
use App\Models\AiDocument;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'en';

        $result = $this->gemini->askQuestion($data['question'], $language);

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

        return response()->json(['ok' => true, 'result' => $result]);
    }

    public function summarize(Request $request)
    {
        $data = $request->validate([
            'documents' => 'required|array',
            'language' => 'nullable|string|in:en,bn',
        ]);

        $language = $data['language'] ?? 'bn';

        $result = $this->gemini->summarize($data['documents'], $language);

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

        return response()->json(['ok' => true, 'result' => $result]);
    }
}
