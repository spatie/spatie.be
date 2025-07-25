---
title: Using our guidelines with AI
description: How to make AI agents program with style
weight: 5
---

## Introduction

[Claude Code](https://claude.ai/code) is Anthropic's official CLI tool that helps developers write better code by providing AI-powered assistance directly in your terminal. It can understand and apply coding standards, making it perfect for maintaining consistency across your Laravel projects.

We've created AI-optimized guidelines specifically formatted for Claude Code and similar agents to ensure it generates code that follows Spatie's Laravel & PHP standards.

Our AI-optimized guidelines cover:

- **Core Laravel principles** - Follow documented Laravel conventions first
- **PHP standards** - PSR compliance, type declarations, nullable syntax
- **Class structure** - Typed properties, constructor promotion, traits
- **Control flow** - Early returns, avoiding else statements, happy path patterns
- **Laravel conventions** - Routes, controllers, configuration, artisan commands
- **Naming conventions** - Complete reference for classes, methods, files, and URLs
- **Code quality reminders** - Essential principles for maintainable code

You can view the file with AI-optimized guidelines [here](https://spatie.be/laravel-php-ai-guidelines.md).

## Global Integration using Claude Code

Add the guidelines to your global Claude Code configuration so they're available across all projects:

```bash
# Make sure the Claude configuration file exists
mkdir -p ~/.claude && touch ~/.claude/CLAUDE.md

# Download our guidelines
curl -o ~/.claude/laravel-php-guidelines.md https://spatie.be/laravel-php-ai-guidelines.md

# Tell Claude to read the guidelines file
echo -e '\n## Coding Standards\nWhen working with Laravel/PHP projects, first read the coding guidelines at @~/.claude/laravel-php-guidelines.md' >> ~/.claude/CLAUDE.md
```

## Project-Specific Integration using Claude Code

For individual Laravel projects, download the guidelines to your project root:

```bash
# Make sure the Claude configuration file exists
touch CLAUDE.md

# Download our guidelines
curl -o laravel-php-guidelines.md https://spatie.be/laravel-php-ai-guidelines.md

# Tell Claude to read the guidelines file
echo -e '\n## Coding Standards\nWhen working on this Laravel/PHP project, first read the coding guidelines at @docs/laravel-php-guidelines.md' >> CLAUDE.md
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
