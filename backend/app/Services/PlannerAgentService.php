<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlannerAgentService
{
    public function analyze(string $name, ?string $description): array
    {
        $prompt = <<<PROMPT
You are a senior software architect.

Analyze this project:

Name: {$name}
Description: {$description}

Return ONLY valid JSON:

{
  "goal": "string",
  "summary": "string",
  "modules": ["string"],
  "estimated_complexity": "low|medium|high"
}

IMPORTANT:
- Return ONLY JSON
- No explanation
- No markdown
- No extra text

PROMPT;

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

        return json_decode($text, true) ?? [
            'error' => 'Invalid JSON returned',
            'raw_response' => $text
        ];
    }
}
