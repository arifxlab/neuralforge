<?php

namespace App\Services;

class RiskAgentService
{
    public function __construct(
        private LLMResponseService $llm
    ) {}

    public function assess(array $analysis): array
    {
        $prompt = <<<PROMPT
You are a senior security and risk analyst.

Given this project analysis:

{$this->formatAnalysis($analysis)}

Return ONLY valid JSON:

{
  "risks": {
    "technical": ["string"],
    "business": ["string"],
    "security": ["string"],
    "overall_risk_level": "low|medium|high"
  }
}

IMPORTANT:
- Return ONLY JSON
- No explanation
- No markdown
- No extra text
- If unsure, return empty arrays

PROMPT;

        return $this->llm->generateJson($prompt);
    }

    private function formatAnalysis(array $analysis): string
    {
        return json_encode($analysis, JSON_PRETTY_PRINT);
    }
}
