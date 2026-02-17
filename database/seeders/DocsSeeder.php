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
        Repository::query()->updateOrCreate(
            ['name' => 'laravel-data'],
            [
                'description' => 'Powerful data objects for Laravel',
                'stars' => 5000,
                'downloads' => 1000000,
                'language' => 'PHP',
                'type' => 'package',
                'visible' => true,
            ],
        );

        $docsPath = storage_path('docs/laravel-data');
        $aliasPath = "{$docsPath}/v4";

        File::ensureDirectoryExists($aliasPath);

        File::put("{$docsPath}/_index.md", <<<'MD'
---
title: laravel-data
category: Laravel
---
MD);

        File::put("{$aliasPath}/_index.md", <<<'MD'
---
title: v4
slogan: Powerful data objects for Laravel
githubUrl: https://github.com/spatie/laravel-data
branch: main
weight: 1
---
MD);

        File::put("{$aliasPath}/introduction.md", <<<'MD'
---
title: Introduction
weight: 1
---

# Laravel Data

This package enables the creation of rich data objects which can be used in various ways. Using this package you only need to describe your data once:

- instead of a form request, you can use a data object
- instead of an API transformer, you can use a data object
- instead of manually writing a typescript definition, you can use a data object

## Are you a visual learner?

Here's a video that explains the basics of the package.

## We have badges!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-data.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-data)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spatie/laravel-data/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/laravel-data/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-data.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-data)
MD);

        File::put("{$aliasPath}/getting-started.md", <<<'MD'
---
title: Getting Started
weight: 2
---

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-data
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="data-config"
```

## Your first data object

A data object is a simple PHP class that extends `Spatie\LaravelData\Data`:

```php
use Spatie\LaravelData\Data;

class SongData extends Data
{
    public function __construct(
        public string $title,
        public string $artist,
    ) {
    }
}
```

You can create a data object from a request:

```php
SongData::from($request);
```

Or from an array:

```php
SongData::from(['title' => 'Never gonna give you up', 'artist' => 'Rick Astley']);
```
MD);

        Cache::store('docs')->flush();
    }
}
