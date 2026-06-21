<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\AgentOutput;
use App\Models\Blueprint;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'processing',
        ]);

        $agentOutput = AgentOutput::create([
            'project_id' => $project->id,
            'agent_name' => 'PlannerAgent',
            'output' => 'Project analysis completed.',
        ]);

        $blueprint = Blueprint::create([
            'project_id' => $project->id,
            'final_output' => 'Blueprint generated successfully.',
        ]);

        $project->update([
            'status' => 'completed',
        ]);

        return response()->json([
            'message' => 'Project processed successfully',
            'project' => $project,
            'agent_output' => $agentOutput,
            'blueprint' => $blueprint,
        ]);
    }
}
