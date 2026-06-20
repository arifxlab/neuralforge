API 1 — Create Project

User submits an idea.

Endpoint
POST /api/projects
Request
{
"title": "CRM Platform",
"description": "CRM for 10000 users"
}
Response
{
"id": 1,
"title": "CRM Platform",
"status": "pending"
}

API 2 — List Projects

Endpoint
GET /api/projects
Response
[
{
"id": 1,
"title": "CRM Platform",
"status": "completed"
}
]

API 3 — Project Details

Endpoint
GET /api/projects/{id}
Response
{
"id": 1,
"title": "CRM Platform",
"description": "...",
"status": "completed"
}

API 4 — Generate Blueprint

This is where AI starts.

Endpoint
POST /api/projects/{id}/generate
Response
{
"message": "Generation started"
}

Laravel will call the Python AI service.

API 5 — Get Blueprint

Endpoint
GET /api/projects/{id}/blueprint
Response
{
"architecture": "...",
"database": "...",
"security": "..."
}

API 6 — Get Agent Outputs

Endpoint
GET /api/projects/{id}/agents
Response
[
{
"agent": "architect",
"content": "..."
},
{
"agent": "database",
"content": "..."
}
]

User
|
V
Create Project
|
V
Project Stored
|
V
Generate Blueprint
|
V
Laravel Calls Python
|
V
Architect Agent
|
V
Database Agent
|
V
Security Agent
|
V
Blueprint Created
|
V
User Views Results