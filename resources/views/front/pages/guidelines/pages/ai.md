---
title: Using our guidelines with AI
description: Agents can have style too.
weight: 8
---

## Introduction

We've created AI-optimized guidelines specifically formatted for AI assistants like Claude Code and GitHub Copilot to ensure they generate code that follows Spatie's Laravel & PHP standards.

Our AI-optimized guidelines cover:

- **Core Laravel principles** - Follow documented Laravel conventions first
- **PHP standards** - PSR compliance, type declarations, nullable syntax
- **Class structure** - Typed properties, constructor promotion, traits
- **Control flow** - Early returns, avoiding else statements, happy path patterns
- **Laravel conventions** - Routes, controllers, configuration, artisan commands
- **Naming conventions** - Complete reference for classes, methods, files, and URLs
- **Code quality reminders** - Essential principles for maintainable code

## Using Laravel Boost (Recommended)

The easiest way to use our guidelines in your Laravel projects is with [Laravel Boost](https://github.com/jasonmccreary/laravel-boost). Simply install our guideline package:

```bash
composer require spatie/boost-spatie-guidelines --dev
php artisan boost:install
```

Select the Spatie guidelines from the list, and you're done! AI assistants using Laravel Boost will automatically reference our guidelines when generating code.

**[View the package on GitHub →](https://github.com/spatie/boost-spatie-guidelines)**

You can view the raw AI-optimized guidelines file [here](https://spatie.be/laravel-php-ai-guidelines.md).

## Alternative: Global Integration using Claude Code

If you're not using Laravel Boost, you can add the guidelines to your global Claude Code configuration so they're available across all projects:

```bash
# Make sure the Claude configuration file exists
mkdir -p ~/.claude && touch ~/.claude/CLAUDE.md

# Download our guidelines
curl -o ~/.claude/laravel-php-guidelines.md https://spatie.be/laravel-php-ai-guidelines.md

# Tell Claude to read the guidelines file
echo -e '\n## Coding Standards\nWhen working with Laravel/PHP projects, first read the coding guidelines at @~/.claude/laravel-php-guidelines.md' >> ~/.claude/CLAUDE.md
```

## Alternative: Project-Specific Integration using Claude Code

For individual Laravel projects not using Laravel Boost, you can download the guidelines to your project root:

```bash
# Make sure the Claude configuration file exists
touch CLAUDE.md

# Download our guidelines
curl -o laravel-php-guidelines.md https://spatie.be/laravel-php-ai-guidelines.md

# Tell Claude to read the guidelines file
echo -e '\n## Coding Standards\nWhen working on this Laravel/PHP project, first read the coding guidelines at @laravel-php-guidelines.md' >> CLAUDE.md
```

Optionally, you can create a Composer script to keep guidelines updated:

```json
{
    "scripts": {
        "update-guidelines": "curl -o docs/laravel-php-guidelines.md https://spatie.be/laravel-php-ai-guidelines.md"
    }
}
```

## AI docs for Spatie packages

The [Context7 MCP project](https://github.com/upstash/context7) contains docs for various Spatie packages.
