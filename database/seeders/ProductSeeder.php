<?php

namespace Database\Seeders;

use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\Product;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Release;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $imagePath = fn (string $slug, string $ext) => database_path("seeders/images/products/{$slug}.{$ext}");

        $ray = Product::factory()->create([
            'title' => 'Ray',
            'slug' => 'ray',
            'description' => 'Ray is a desktop debugging app that keeps the instant feedback you get from console.log() and dump() but lets you use the same debugging syntax across Laravel, PHP, JavaScript and more.',
            'long_description' => '<p>Ray is a desktop debugging app that keeps the instant feedback you get from <code>console.log()</code> and <code>dump()</code> but lets you use the same debugging syntax across Laravel, PHP, JavaScript and more frameworks and languages.</p><ul><li><p>Send anything you want to Ray, including emails, jobs, queries, HTML, markdown.</p></li><li><p>View and interact with output your AI sends to Ray using our MCP server</p></li><li><p>Measure performance and pause execution in PHP</p></li><li><p>Beautifully designed with themes to match your style</p></li></ul><p>Download our free trial and send up to 20 messages each session. Enjoying Ray? Buy a license to unlock the app and get full access.</p>',
            'url' => 'https://myray.app',
            'action_url' => '',
            'action_label' => 'Buy Ray',
            'private_key' => file_get_contents(database_path('factories/stubs/privateKey')),
            'maximum_activation_count' => 2,
        ]);
        $ray->addMedia($imagePath('ray', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        $rayRenewalPurchasable = Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_STANDARD_RENEWAL,
            'title' => 'Ray renewal',
            'description' => 'Ray renewal',
            'paddle_product_id' => '636791',
            'requires_license' => true,
            'product_id' => $ray->id,
            'renewal_purchasable_id' => null,
            'price_in_usd_cents' => 1900,
        ]);

        Release::factory()->count(5)->create([
            'product_id' => $ray->id,
        ]);

        Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_STANDARD,
            'title' => 'Ray license',
            'description' => 'Ray license',
            'paddle_product_id' => '636791',
            'requires_license' => true,
            'product_id' => $ray->id,
            'renewal_purchasable_id' => $rayRenewalPurchasable->id,
            'price_in_usd_cents' => 1900,
        ]);

        $flare = Product::factory()->create([
            'title' => 'Flare',
            'slug' => 'flare',
            'description' => 'Laravel Error Tracking',
            'long_description' => "Flare monitors your PHP and JavaScript applications and tracks all errors when things go wrong.\nFor common issues, Flare suggests solutions and related documentation. The best part? In local development, the Ignition error page can automatically fix things for you with a single click.\nLaravel error tracking has never been more comfortable.",
            'url' => 'https://flareapp.io',
            'action_url' => 'https://flareapp.io',
            'action_label' => 'Visit flareapp.io',
            'external' => true,
        ]);
        $flare->addMedia($imagePath('flare', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        $beyondCrud = Product::factory()->create([
            'title' => 'Laravel Beyond CRUD',
            'slug' => 'laravel-beyond-crud',
            'description' => 'The knowledge in this course is built from the years of experience our team has building large, robust applications.',
            'long_description' => "The knowledge in this course is built from the years of experience our team has building large, robust applications.\n\nThe **ebook** is your guide for building large maintainable Laravel applications. Along the way, you'll be introduced to concepts like DDD and hexagonal design, all while still embracing Laravel's focus on elegant code.",
            'url' => 'https://laravel-beyond-crud.com/',
            'action_url' => '',
            'action_label' => 'Buy course',
        ]);
        $beyondCrud->addMedia($imagePath('laravel-beyond-crud', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_STANDARD,
            'title' => 'Laravel Beyond CRUD course access',
            'description' => 'Course access',
            'paddle_product_id' => '578345',
            'requires_license' => false,
            'product_id' => $beyondCrud->id,
            'renewal_purchasable_id' => null,
            'price_in_usd_cents' => 24900,
        ]);

        $mailCoach = Product::factory()->create([
            'title' => 'Mailcoach Self-Hosted',
            'slug' => 'mailcoach',
            'description' => 'Powerful email marketing, automations and transactional emails, seamlessly integrated into your Laravel application.',
            'long_description' => "Powerful email marketing, automations and transactional emails, seamlessly integrated into your Laravel application.\n\nMailcoach Self-Hosted lets you manage your contact lists and send marketing, automated and transactional emails from within Laravel.",
            'url' => 'https://mailcoach.app',
            'action_url' => '',
            'action_label' => 'Buy license or course',
        ]);
        $mailCoach->addMedia($imagePath('mailcoach', 'png'))->preservingOriginal()->toMediaCollection('product-image');

        Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_VIDEOS,
            'title' => 'Only the videos',
            'description' => 'Videos',
            'paddle_product_id' => '579713',
            'requires_license' => false,
            'product_id' => $mailCoach->id,
            'price_in_usd_cents' => 4900,
        ]);

        $mailCoachSingleDomainRenewal = Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_STANDARD_RENEWAL,
            'title' => 'Mailcoach single domain renewal',
            'description' => '- Is valid for one domain or subdomain
- Includes the package, app and videos
- Includes 1 year of updates and access to our private repository
- Is renewable if you want to stay on the latest release',
            'paddle_product_id' => '579712',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
            'price_in_usd_cents' => 14900,
        ]);

        Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_STANDARD,
            'title' => 'Mailcoach single domain',
            'description' => 'Standard license',
            'paddle_product_id' => '578345',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
            'renewal_purchasable_id' => $mailCoachSingleDomainRenewal->id,
            'price_in_usd_cents' => 14900,
        ]);

        $mailCoachUnlimitedDomainsRenewal = Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS_RENEWAL,
            'title' => 'Mailcoach unlimited domains renewal',
            'description' => 'Unlimited domains renewal license',
            'paddle_product_id' => '594796',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
            'price_in_usd_cents' => 99900,
        ]);

        Purchasable::factory()->create([
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
            'title' => 'Mailcoach unlimited domains',
            'description' => 'Unlimited domains license',
            'paddle_product_id' => '594793',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
            'renewal_purchasable_id' => $mailCoachUnlimitedDomainsRenewal->id,
            'price_in_usd_cents' => 99900,
        ]);

        Product::factory()->create([
            'title' => 'Media Library Pro',
            'slug' => 'media-library-pro',
            'description' => 'UI components for spatie/laravel-medialibrary. Includes React, Vue and Livewire v3 components, Laravel Vapor support, temporary uploads and Tailwind CSS styling.',
            'long_description' => '<p>UI components for <a href="https://spatie.be/docs/laravel-medialibrary">spatie/laravel-medialibrary</a></p><p><strong>Includes:</strong></p><ul><li>React, Vue and Livewire v3 components</li><li>Laravel Vapor support</li><li>Temporary uploads</li><li>Tailwind CSS styles</li></ul>',
            'url' => 'https://medialibrary.pro',
            'action_url' => '',
            'action_label' => 'Buy license',
        ])->addMedia($imagePath('media-library-pro', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Product::factory()->create([
            'title' => 'Front Line PHP',
            'slug' => 'front-line-php',
            'description' => 'Over the years, PHP has become a modern, performant and overall fun programming language. This ebook will get you up to speed with modern-day PHP syntax.',
            'long_description' => '<p>Over the years, PHP has become a modern, performant and overall fun programming language. This ebook will get you up to speed with modern-day PHP syntax, learn about the new stuff added in PHP and teach you about patterns, best practices; as well as the PHP community as we know it today.</p>',
            'url' => 'https://front-line-php.com',
            'action_url' => '',
            'action_label' => 'Buy ebook',
        ])->addMedia($imagePath('front-line-php', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Product::factory()->create([
            'title' => 'Testing Laravel',
            'slug' => 'testing-laravel',
            'description' => 'Testing is a fundamental skill for every developer. In this course you\'ll learn how to write quality tests to make sure your Laravel application is working correctly.',
            'long_description' => "Testing is a fundamental skill for every developer. In this course you will learn how to write quality tests to make sure your Laravel application is working correctly.\n\nYou will learn how to write a test suite from scratch. We will cover how to make sure your homepage works, how you can test form submissions, what the different types of tests are, and much more!",
            'url' => 'https://testing-laravel.com',
            'action_url' => '',
            'action_label' => 'Buy course',
        ])->addMedia($imagePath('testing-laravel', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Product::factory()->create([
            'title' => 'Event Sourcing in Laravel',
            'slug' => 'event-sourcing-in-laravel',
            'description' => 'A hands-on course to start using event sourcing in large apps.',
            'long_description' => 'An extensive book with more than 200 pages, beautifully designed and illustrated. We will cover everything related to event sourcing and event-driven design: from the basics of an event-driven mindset to complex event sourcing patterns like CQRS, event versioning and state management.',
            'url' => 'https://event-sourcing-laravel.com',
            'action_url' => '',
            'action_label' => 'Buy course',
        ])->addMedia($imagePath('event-sourcing-in-laravel', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Product::factory()->create([
            'title' => 'Writing Readable PHP',
            'slug' => 'writing-readable-php',
            'description' => 'Learn how to write PHP that is a joy to read and easy to understand.',
            'long_description' => "Stop the madness! Let us learn how to write readable PHP in this hands-on course consisting of both written examples and over 2 hours of high quality video content.\n\nLearn how to write code that is a joy to read for your co-workers and future self. You will learn dozens of tips and tricks that will increase code readability today.",
            'url' => 'https://writing-readable-php.com',
            'action_url' => '',
            'action_label' => 'Buy ebook',
        ])->addMedia($imagePath('writing-readable-php', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Product::factory()->create([
            'title' => 'Laravel Package Training v2.0',
            'slug' => 'laravel-package-training',
            'description' => 'Having produced over 500 packages, with more than 2 billion downloads in total, we know what we\'re talking about.',
            'long_description' => '<p>Having produced over 500 packages, with more than 2 billion downloads in total, we know what we are talking about. Dive into the minds of the people that brought you quality packages like laravel-permission, laravel-backup, browsershot, laravel-medialibrary.</p>',
            'url' => 'https://laravelpackage.training',
            'action_url' => '',
            'action_label' => 'Buy course',
        ])->addMedia($imagePath('laravel-package-training', 'jpg'))->preservingOriginal()->toMediaCollection('product-image');

        Product::factory()->create([
            'title' => 'Laravel Comments',
            'slug' => 'laravel-comments',
            'description' => 'Laravel Comments contains a drop-in Livewire component that allows you to add comments to any Laravel app in no time.',
            'long_description' => "Laravel Comments contains a drop-in Livewire component that allows you to add comments to any Laravel app in no time.\n\nIt features nested comments, emoji reactions, notifications, markdown and code highlighting, endless customization options, and support for Livewire 3.",
            'url' => 'https://spatie.be/products/laravel-comments',
            'action_url' => '',
            'action_label' => 'Buy license',
        ])->addMedia($imagePath('laravel-comments', 'png'))->preservingOriginal()->toMediaCollection('product-image');
    }
}
