<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class AgentSkillsController
{
    private string $name = 'following-spatie-laravel-php-guidelines';

    private string $description = 'Applies Spatie coding conventions when writing or reviewing Laravel and PHP code. Use when asked to follow Spatie guidelines or contribute to a Spatie PHP project.';

    public function index(): JsonResponse
    {
        return response()->json([
            '$schema' => 'https://schemas.agentskills.io/discovery/0.2.0/schema.json',
            'skills' => [[
                'name' => $this->name,
                'type' => 'skill-md',
                'description' => $this->description,
                'url' => "/.well-known/agent-skills/{$this->name}/SKILL.md",
                'digest' => 'sha256:'.hash('sha256', $this->show()->getContent()),
            ]],
        ], headers: ['Access-Control-Allow-Origin' => '*']);
    }

    public function show(): Response
    {
        $content = "---\nname: {$this->name}\ndescription: {$this->description}\n---\n\n"
            .File::get(public_path('laravel-php-ai-guidelines.md'));

        return response($content, headers: [
            'Content-Type' => 'text/markdown; charset=UTF-8',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
