<?php

namespace App\Services;

class PlannerAgentService
{
    public function analyze(string $name, ?string $description): array
    {
        return [
            'goal' => $name,

            'summary' => $description,

            'modules' => [
                'API Layer',
                'AI Agent Layer',
                'Database Layer',
                'Monitoring Layer'
            ],

            'estimated_complexity' => 'medium'
        ];
    }
}
