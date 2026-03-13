<?php

namespace Database\Seeders;

use App\Models\Repository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class DocsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedDocs('laravel-data', 'v4', 'Powerful data objects for Laravel');
        $this->seedDocs('laravel-medialibrary', 'v11', 'Associate files with Eloquent models');
        $this->seedDocs('laravel-permission', 'v6', 'Associate users with roles and permissions');
        $this->seedDocs('laravel-query-builder', 'v6', 'Build Eloquent queries from API requests');
        $this->seedDocs('laravel-event-sourcing', 'v7', 'The easiest way to get started with event sourcing in Laravel');
        $this->seedDocs('laravel-activitylog', 'v4', 'Log activity inside your Laravel app');
        $this->seedDocs('laravel-backup', 'v9', 'A package to backup your Laravel app');
        $this->seedDocs('laravel-slack-slash-command', 'v1', 'Handle Slack slash commands in a Laravel app');
        $this->seedDocs('laravel-livewire-wizard', 'v1', 'A package to create wizards using Livewire');
        $this->seedDocs('laravel-responsecache', 'v7', 'Speed up your app by caching the entire response');

        Cache::store('docs')->flush();
    }

    protected function seedDocs(string $name, string $version, string $description): void
    {
        Repository::query()->updateOrCreate(
            ['name' => $name],
            [
                'description' => $description,
                'stars' => 5000,
                'downloads' => 1000000,
                'language' => 'PHP',
                'type' => 'package',
                'visible' => true,
            ],
        );

        $docsPath = storage_path("docs/{$name}");
        $aliasPath = "{$docsPath}/{$version}";

        File::ensureDirectoryExists($aliasPath);

        File::put("{$docsPath}/_index.md", <<<MD
---
title: {$name}
category: Laravel
---
MD);

        File::put("{$aliasPath}/_index.md", <<<MD
---
title: {$version}
slogan: {$description}
githubUrl: https://github.com/spatie/{$name}
branch: main
weight: 1
---
MD);

        File::put("{$aliasPath}/introduction.md", <<<MD
---
title: Introduction
weight: 1
---

# {$name}

{$description}
MD);
    }
}
