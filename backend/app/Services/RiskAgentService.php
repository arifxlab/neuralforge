<?php

namespace App\Services;

class RiskAgentService
{
    public function assess(array $analysis): array
    {
        return [
            'risks' => [
                'Scope creep',
                'Model hallucinations',
                'Infrastructure costs'
            ]
        ];
    }
}
