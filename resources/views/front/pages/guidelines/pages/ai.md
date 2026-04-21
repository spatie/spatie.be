---
title: Using our guidelines with AI
description: Agents can have style too.
weight: 8
---

## Introduction

We've packaged our coding guidelines as AI skills so AI assistants can apply Spatie's conventions more effectively in the right context.

Our skills cover:

- **`spatie-laravel-php`** - Laravel & PHP coding conventions, PSR standards, control flow, and naming
- **`spatie-javascript`** - JavaScript coding standards, Prettier config, functions, and destructuring
- **`spatie-version-control`** - Git workflow conventions, repo and branch naming, and commit messages
- **`spatie-security`** - Application, database, and server security best practices

## Using Laravel Boost (Recommended)

The easiest way to use our guidelines in your Laravel projects is with [Laravel Boost](https://laravel.com/docs/13.x/boost).

If you haven't already, install Laravel Boost, and then our skills package.

```bash
composer require laravel/boost --dev
composer require spatie/guidelines-skills --dev
```

After installing, run the following and select the Spatie guidelines from the list.

```bash
php artisan boost:install
```

Choose the coding agents you want to install Boost for, and you're all set.

**[View the package on GitHub →](https://github.com/spatie/guidelines-skills)**

If you prefer a manual setup, you can still use the raw AI-optimized guidelines file [here](https://spatie.be/laravel-php-ai-guidelines.md).

## Alternative: Using skills.sh

If you're not using Laravel Boost, you can install our skills via [skills.sh](https://skills.sh):

```bash
npx skills add spatie/guidelines-skills
```

This will install the Spatie skills for your AI agent using the `skills.sh` ecosystem.

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

If you use the skills package instead, keep it up to date with one of these commands:

```bash
# When installed through Composer / Laravel Boost
composer update spatie/guidelines-skills
php artisan boost:update

# When installed through skills.sh
npx skills add spatie/guidelines-skills
```

## AI docs for Spatie packages

The [Context7 MCP project](https://github.com/upstash/context7) contains docs for various Spatie packages.
