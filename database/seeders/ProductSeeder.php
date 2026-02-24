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
        $ray = Product::factory()->create([
            'title' => 'Ray',
            'slug' => 'ray',
            'description' => 'Ray is a desktop debugging app that keeps the instant feedback you get from console.log() and dump() but lets you use the same debugging syntax across Laravel, PHP, JavaScript and more.',
            'url' => 'https://myray.app',
            'action_url' => '',
            'action_label' => 'Buy Ray',
            'private_key' => file_get_contents(database_path('factories/stubs/privateKey')),
            'maximum_activation_count' => 2,
        ]);

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
            'url' => 'https://flareapp.io',
            'action_url' => 'https://flareapp.io',
            'action_label' => 'Visit flareapp.io',
            'external' => true,
        ]);

        $beyondCrud = Product::factory()->create([
            'title' => 'Laravel Beyond CRUD',
            'slug' => 'laravel-beyond-crud',
            'description' => 'The knowledge in this course is built from the years of experience our team has building large, robust applications.',
            'url' => 'https://laravel-beyond-crud.com/',
            'action_url' => '',
            'action_label' => 'Buy course',
        ]);

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
            'url' => 'https://mailcoach.app',
            'action_url' => '',
            'action_label' => 'Buy license or course',
        ]);


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
            'url' => 'https://medialibrary.pro',
            'action_url' => '',
            'action_label' => 'Buy license',
        ]);

        Product::factory()->create([
            'title' => 'Front Line PHP',
            'slug' => 'front-line-php',
            'description' => 'Over the years, PHP has become a modern, performant and overall fun programming language. This ebook will get you up to speed with modern-day PHP syntax.',
            'url' => 'https://front-line-php.com',
            'action_url' => '',
            'action_label' => 'Buy ebook',
        ]);

        Product::factory()->create([
            'title' => 'Testing Laravel',
            'slug' => 'testing-laravel',
            'description' => 'Testing is a fundamental skill for every developer. In this course you\'ll learn how to write quality tests to make sure your Laravel application is working correctly.',
            'url' => 'https://testing-laravel.com',
            'action_url' => '',
            'action_label' => 'Buy course',
        ]);

        Product::factory()->create([
            'title' => 'Event Sourcing in Laravel',
            'slug' => 'event-sourcing-in-laravel',
            'description' => 'A hands-on course to start using event sourcing in large apps.',
            'url' => 'https://event-sourcing-laravel.com',
            'action_url' => '',
            'action_label' => 'Buy course',
        ]);

        Product::factory()->create([
            'title' => 'Writing Readable PHP',
            'slug' => 'writing-readable-php',
            'description' => 'Learn how to write PHP that is a joy to read and easy to understand.',
            'url' => 'https://writing-readable-php.com',
            'action_url' => '',
            'action_label' => 'Buy ebook',
        ]);

        Product::factory()->create([
            'title' => 'Laravel Package Training v2.0',
            'slug' => 'laravel-package-training',
            'description' => 'Having produced over 500 packages, with more than 2 billion downloads in total, we know what we\'re talking about.',
            'url' => 'https://laravelpackage.training',
            'action_url' => '',
            'action_label' => 'Buy course',
        ]);

        Product::factory()->create([
            'title' => 'Laravel Comments',
            'slug' => 'laravel-comments',
            'description' => 'Laravel Comments contains a drop-in Livewire component that allows you to add comments to any Laravel app in no time.',
            'url' => 'https://spatie.be/products/laravel-comments',
            'action_url' => '',
            'action_label' => 'Buy license',
        ]);
    }
}
