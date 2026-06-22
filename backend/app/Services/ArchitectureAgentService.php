<?php

namespace App\Services;

class ArchitectureAgentService
{
    public function __construct(
        private LLMResponseService $llm
    ) {}

    public function design(array $analysis): array
    {
        $prompt = <<<PROMPT
You are a senior software architect.

Given this project analysis:

{$this->formatAnalysis($analysis)}

Return ONLY valid JSON:

{
  "architecture_style": "string",
  "backend": "string",
  "database": "string",
  "deployment": "string",
  "api_style": "string",
  "recommended_services": ["string"]
}

IMPORTANT:
- Return ONLY JSON
- No explanation
- No markdown
- No extra text

PROMPT;

        return $this->llm->generateJson($prompt);
    }

    private function formatAnalysis(array $analysis): string
    {
        return json_encode($analysis, JSON_PRETTY_PRINT);
    }
}
