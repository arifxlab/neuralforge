<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlannerAgentService
{
    public function analyze(string $name, ?string $description): array
    {
        $prompt = <<<PROMPT
You are a senior software architect.

Analyze this project.

Name: {$name}
Description: {$description}

Return ONLY valid JSON.

{
  "goal": "string",
  "summary": "string",
  "modules": ["string"],
  "estimated_complexity": "low|medium|high"
}

Do not add explanations.
Do not use markdown.
Do not wrap in code blocks.
PROMPT;

        $response = Http::timeout(120)
            ->post('http://127.0.0.1:11434/api/generate', [
                'model' => 'llama3',
                'prompt' => $prompt,
                'stream' => false,
            ]);

        $content = $response->json('response');

        $decoded = json_decode($content, true);

        if (!$decoded) {
            return [
                'error' => 'Invalid JSON returned',
                'raw_response' => $content
            ];
        }

        return $decoded;
    }
}
