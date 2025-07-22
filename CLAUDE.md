# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

### Development
```bash
# Install dependencies
composer install
yarn install

# Run development servers
php artisan serve
yarn dev

# Database setup
php artisan migrate
php artisan db:seed
```

### Testing
```bash
# Run all tests in parallel
composer test
./vendor/bin/pest --parallel

# Run a specific test file
./vendor/bin/pest tests/Feature/ExampleTest.php

# Run tests matching a pattern
./vendor/bin/pest --filter "test name pattern"
```

### Code Quality
```bash
# Static analysis
composer analyse
vendor/bin/phpstan analyse --memory-limit=2G

# Format code
composer format
vendor/bin/php-cs-fixer fix --allow-risky=yes

# Generate PHPStan baseline
composer baseline
```

### Deployment
```bash
# Deploy to production
composer deploy
./vendor/bin/envoy run deploy

# Deploy code only (no migrations/build)
composer deploy-code
./vendor/bin/envoy run deploy-code
```

### Maintenance
```bash
# Import documentation from Spatie packages
php artisan import:docs

# Import GitHub repositories data
php artisan import:github-repositories

# Generate IDE helpers
composer ide-helper

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Horizon queue management
php artisan horizon
php artisan horizon:status
```

### Configuration
```bash
# Copy coding guidelines to global Claude config
cp public/laravel-php-ai-guidelines.md ~/.claude/CLAUDE.md

# Or append to existing global config
echo -e "\n## Coding Standards\nFollow the Laravel & PHP guidelines in \`public/laravel-php-ai-guidelines.md\`." >> ~/.claude/CLAUDE.md
```

## Architecture

### Tech Stack
- **Laravel 11** with PHP 8.4+
- **Livewire 3** for interactive components
- **Filament 3** for admin panel
- **Alpine.js** and **React** for frontend interactivity
- **Tailwind CSS** with extensive customization
- **Vite** for asset building
- **MySQL** database with **Redis** for caching/queues
- **Horizon** for queue monitoring
- **Pest** for testing

### Domain Structure
The codebase follows Laravel conventions with domain-driven design elements:

- `app/Domain/` - Domain-specific logic organized by feature:
  - `Experience/` - Resume/CV functionality
  - `Shop/` - E-commerce for digital products
  - `GitHub/` - GitHub repository integration
- `app/Actions/` - Single-purpose action classes
- `app/Livewire/` - Livewire components
- `app/Filament/` - Admin panel customizations
- `app/Http/Front/Controllers/` - Public-facing controllers
- `app/Http/Api/Controllers/` - API endpoints

### Key Features
1. **Documentation System** - Imports and displays docs for Spatie packages
2. **E-commerce** - Sells courses, videos, and packages via Paddle
3. **Content Management** - Blog posts, insights, courses
4. **GitHub Integration** - Showcases open source repositories
5. **User System** - Authentication, purchases, profiles
6. **Admin Panel** - Filament-based administration

### Testing Strategy
- Uses Pest PHP testing framework
- Tests located in `tests/Feature/` and `tests/Unit/`
- Database transactions for test isolation
- Factories for test data generation

### Important Integrations
- **Paddle** - Payment processing (see `app/Domain/Shop/`)
- **GitHub API** - Repository synchronization
- **Vimeo** - Video hosting for courses
- **Mailcoach** - Newsletter management
- **GeoIP** - Location-based pricing (PPP)

### Security Considerations
- API authentication uses Laravel Sanctum tokens
- Signed URLs for secure downloads
- Environment-based configuration
- Never commit `.env` files or secrets

### Development Tips
- Run `yarn dev` in a separate terminal for asset watching
- Use `php artisan tinker` for quick debugging
- Check `storage/logs/laravel.log` for errors
- Horizon dashboard available at `/horizon` (requires authentication)
- Debug bar available in local environment (bottom of page)