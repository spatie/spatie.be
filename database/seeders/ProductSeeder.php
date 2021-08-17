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
            'slug' => 'Ray',
            'description' => 'Ray',
            'url' => 'https://ray',
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
            'title' => 'Timber',
            'description' => 'Timber',
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
            'description' => 'Learn how to build larger-than-average Laravel applications and maintain them for years to come.',
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
            'title' => 'Mailcoach',
            'slug' => 'mailcoach',
            'description' => 'Self-host your email marketing software',
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
            'title' => 'Medialibrary.pro',
            'slug' => 'medialibrary_pro',
            'description' => 'Every picture needs a frame',
            'url' => 'https://medialibrary.pro',
            'action_url' => '',
            'action_label' => 'Buy license',
        ]);
    }
}
