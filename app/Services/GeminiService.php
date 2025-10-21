<?php

namespace App\Services;

use GuzzleHttp\Client;

class GeminiService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = env('GEMINI_API_URL', 'https://api.gemini.example/v1');
        $this->client = new Client(['base_uri' => $this->baseUrl, 'timeout' => 30]);
    }

    public function askQuestion(string $question, string $language = 'en')
    {
        $payload = [
            'question' => $question,
            'language' => $language,
        ];

        $response = $this->client->post('/ask', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function summarize(array $documentFiles, string $language = 'bn')
    {
        // In practice you'd upload files or their content. For now accept array of text bodies.
        $payload = [
            'documents' => $documentFiles,
            'language' => $language,
        ];

        $response = $this->client->post('/summarize', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
