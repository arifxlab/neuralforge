<?php

namespace App\Services;

class BlueprintAgentService
{
    public function __construct(
        private LLMResponseService $llm
    ) {}

    public function generate(
        array $analysis,
        array $architecture,
        array $risks
    ): array {

        $prompt = <<<PROMPT
You are a senior system architect.

You are given outputs from multiple AI agents:

1. Analysis:
{$this->format($analysis)}

2. Architecture:
{$this->format($architecture)}

3. Risks:
{$this->format($risks)}

Now generate a FINAL SYSTEM BLUEPRINT.

Return ONLY valid JSON:

{
  "summary": "string",
  "architecture_overview": "string",
  "core_components": ["string"],
  "data_flow": "string",
  "risk_mitigation": ["string"],
  "final_recommendation": "string"
}

Do not explain.
Do not use markdown.
Return JSON only.
PROMPT;

        return $this->llm->generateJson($prompt);
    }

    private function format(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
