<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentOutput extends Model
{
    protected $fillable = [
        'project_id',
        'agent_name',
        'output',
        'context',
    ];
}
