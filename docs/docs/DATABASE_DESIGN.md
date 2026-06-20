# Database Design

## Users

- id
- name
- email
- password
- created_at
- updated_at

---

## Projects

- id
- user_id
- title
- description
- status
- created_at
- updated_at

---

## Agent Outputs

- id
- project_id
- agent_name
- content
- created_at

---

## Blueprints

- id
- project_id
- architecture_section
- database_section
- security_section
- created_at