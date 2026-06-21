<?php

namespace App\Services;

class ArchitectureAgentService
{
    public function design(array $analysis): array
    {
        return [
            'backend' => 'Laravel 13',
            'database' => 'PostgreSQL',
            'deployment' => 'Docker',
            'api_style' => 'REST'
        ];
    }
}
