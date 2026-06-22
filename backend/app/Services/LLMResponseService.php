<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LLMResponseService
{
    public function generateJson(string $prompt): array
    {
        $response = Http::timeout(120)
            ->post('http://127.0.0.1:11434/api/generate', [
                'model' => 'llama3',
                'prompt' => $prompt,
                'stream' => false,
                'options' => [
                    'temperature' => 0.2
                ]
            ]);

        $text = $response->json('response') ?? '';

        return $this->extractJson($text);
    }

    private function extractJson(string $text): array
    {
        $text = trim($text);

        // 1. Try direct decode first
        $decoded = json_decode($text, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // 2. Extract first JSON block safely
        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start === false || $end === false) {
            return [
                'error' => 'No JSON found',
                'raw_response' => $text
            ];
        }

        $json = substr($text, $start, $end - $start + 1);

        // 3. Clean common LLM mistakes
        $json = $this->cleanJsonString($json);

        $decoded = json_decode($json, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // 4. Final safe fallback
        return [
            'error' => 'Invalid JSON from LLM',
            'raw_response' => $text
        ];
    }

    private function cleanJsonString(string $json): string
    {
        // remove trailing commas (common LLM issue)
        $json = preg_replace('/,\s*}/', '}', $json);
        $json = preg_replace('/,\s*\]/', ']', $json);

        // remove markdown artifacts if any
        $json = str_replace(['```json', '```'], '', $json);

        return trim($json);
    }
}
