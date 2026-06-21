<?php

namespace App\Services;

class BlueprintAgentService
{
    public function generate(
        array $analysis,
        array $architecture,
        array $risks
    ): array {
        return [
            'analysis' => $analysis,
            'architecture' => $architecture,
            'risks' => $risks
        ];
    }
}
