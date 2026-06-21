<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlannerAgentService
{
    public function analyze(string $name, ?string $description): array
    {
        $prompt = "
Analyze this software project:

Name: {$name}
Description: {$description}

Give a short architecture recommendation.
";

        $response = Http::timeout(120)
            ->post('http://127.0.0.1:11434/api/generate', [
                'model' => 'llama3',
                'prompt' => $prompt,
                'stream' => false,
            ]);

        return [
            'raw_response' => $response->json('response')
        ];
    }
}
