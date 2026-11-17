<?php

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

it('discovers a downloadable skill with matching metadata, digest and current guidelines', function () {
    $index = $this->get('/.well-known/agent-skills/index.json')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/json')
        ->assertHeader('Access-Control-Allow-Origin', '*')
        ->assertJsonPath('$schema', 'https://schemas.agentskills.io/discovery/0.2.0/schema.json');

    $skill = $index->json('skills.0');
    $response = $this->get($skill['url'])
        ->assertOk()
        ->assertHeader('Content-Type', 'text/markdown; charset=UTF-8')
        ->assertHeader('Access-Control-Allow-Origin', '*')
        ->assertHeaderMissing('Set-Cookie');

    $document = YamlFrontMatter::parse($response->getContent());

    expect($skill['type'])->toBe('skill-md')
        ->and($skill['digest'])->toBe('sha256:'.hash('sha256', $response->getContent()))
        ->and($document->name)->toBe($skill['name'])
        ->and($document->description)->toBe($skill['description'])
        ->and(trim($document->body()))->toBe(trim(File::get(public_path('laravel-php-ai-guidelines.md'))));

    $this->head($skill['url'])->assertOk()->assertContent('');
    $this->head('/.well-known/agent-skills/index.json')->assertOk()->assertContent('');
    $this->get('/.well-known/agent-skills/unknown/SKILL.md')->assertNotFound();
});
