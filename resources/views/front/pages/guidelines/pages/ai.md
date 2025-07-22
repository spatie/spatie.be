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

## Global integration using Claude Code

Add the guidelines to your global Claude Code configuration so they're available across all projects:

```bash
# Remove existing Spatie guidelines and append new ones
sed -i '/<!-- SPATIE-GUIDELINES-START -->/,/<!-- SPATIE-GUIDELINES-END -->/d' ~/.claude/CLAUDE.md 2>/dev/null || true
echo -e "\n## Coding Standards\n<!-- SPATIE-GUIDELINES-START -->\nWhen working with Laravel/PHP projects, follow these Spatie guidelines:\n\`\`\`" >> ~/.claude/CLAUDE.md
curl -s https://spatie.be/laravel-php-ai-guidelines.md >> ~/.claude/CLAUDE.md
echo -e "\`\`\`\n<!-- SPATIE-GUIDELINES-END -->" >> ~/.claude/CLAUDE.md
```

## Project specific integration using Claude Code

For individual Laravel projects, download and inline the guidelines in your project:

```bash
# Remove existing Spatie guidelines and append new ones
sed -i '/<!-- SPATIE-GUIDELINES-START -->/,/<!-- SPATIE-GUIDELINES-END -->/d' CLAUDE.md 2>/dev/null || true
echo -e "\n## Coding Standards\n<!-- SPATIE-GUIDELINES-START -->\nWhen working on this Laravel/PHP project, follow these Spatie guidelines:\n\`\`\`" >> CLAUDE.md
curl -s https://spatie.be/laravel-php-ai-guidelines.md >> CLAUDE.md
echo -e "\`\`\`\n<!-- SPATIE-GUIDELINES-END -->" >> CLAUDE.md
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
