<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\AgentOutput;
use App\Models\Blueprint;
use App\Services\PlannerAgentService;
use App\Services\ArchitectureAgentService;
use App\Services\RiskAgentService;
use App\Services\BlueprintAgentService;

class ProjectController extends Controller
{
    public function store(
        Request $request,
        PlannerAgentService $planner,
        ArchitectureAgentService $architectureAgent,
        RiskAgentService $riskAgent,
        BlueprintAgentService $blueprintAgent
    ) {
        // 1. Planner Agent
        $analysis = $planner->analyze(
            $request->name,
            $request->description
        );

        // 2. Architecture Agent
        $architecture = $architectureAgent->design($analysis);

        // 3. Risk Agent
        $risks = $riskAgent->assess($analysis);

        // 4. Save Project
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'processing',
            'metadata' => $analysis
        ]);

        // 5. Save Agent Logs
        AgentOutput::create([
            'project_id' => $project->id,
            'agent_name' => 'PlannerAgent',
            'output' => json_encode($analysis, JSON_PRETTY_PRINT),
        ]);

        AgentOutput::create([
            'project_id' => $project->id,
            'agent_name' => 'ArchitectureAgent',
            'output' => json_encode($architecture, JSON_PRETTY_PRINT),
        ]);

        AgentOutput::create([
            'project_id' => $project->id,
            'agent_name' => 'RiskAgent',
            'output' => json_encode($risks, JSON_PRETTY_PRINT),
        ]);

        // 6. Final Blueprint Agent
        $blueprint = $blueprintAgent->generate(
            $analysis,
            $architecture,
            $risks
        );

        $blueprintRecord = Blueprint::create([
            'project_id' => $project->id,
            'final_output' => json_encode($blueprint, JSON_PRETTY_PRINT),
        ]);

        // 7. Mark complete
        $project->update([
            'status' => 'completed'
        ]);

        // 8. Response
        return response()->json([
            'message' => 'NeuralForge pipeline executed successfully',
            'project' => $project,
            'pipeline' => [
                'analysis' => $analysis,
                'architecture' => $architecture,
                'risks' => $risks,
                'blueprint' => $blueprint
            ]
        ]);
    }
}
