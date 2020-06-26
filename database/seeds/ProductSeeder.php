<?php

use App\Enums\PurchasableType;
use App\Models\Product;
use App\Models\Purchasable;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $flare = factory(Product::class)->create([
            'title' => 'Flare',
            'slug' => 'flare',
            'description' => 'Laravel Error Tracking',
            'url' => 'https://flareapp.io',
            'action_url' => 'https://flareapp.io',
            'action_label' => 'Flare',
        ]);

        $mailCoach = factory(Product::class)->create([
            'title' => 'Mailcoach',
            'slug' => 'mailcoach',
            'description' => 'Self-host your email marketing software',
            'url' => 'https://mailcoach.app',
            'action_url' => 'https://mailcoach.app',
            'action_label' => 'Mailcoach',
        ]);

        factory(Product::class)->create([
            'title' => 'Medialibrary.pro',
            'slug' => 'medialibrary_pro',
            'description' => 'Every picture needs a frame',
            'url' => 'https://medialibrary.pro',
            'action_url' => 'https://medialibrary.pro',
            'action_label' => 'Medialibrary.pro',
        ]);

        $mailCoachSingleDomainRenewal = factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_STANDARD_RENEWAL,
            'title' => 'Mailcoach single domain renewal',
            'description' => 'Standard renewal license',
            'paddle_product_id' => '579712',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_STANDARD,
            'title' => 'Mailcoach single domain',
            'description' => 'Standard license',
            'paddle_product_id' => '578345',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
            'renewal_purchasable_id' => $mailCoachSingleDomainRenewal->id,
        ]);

        $mailCoachUnlimitedDomainsRenewal = factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS_RENEWAL,
            'title' => 'Mailcoach unlimited domains renewal',
            'description' => 'Unlimited domains renewal license',
            'paddle_product_id' => '594796',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
            'title' => 'Mailcoach unlimited domains',
            'description' => 'Unlimited domains license',
            'paddle_product_id' => '594793',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
            'renewal_purchasable_id' => $mailCoachUnlimitedDomainsRenewal->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_VIDEOS,
            'title' => 'Only the videos',
            'description' => 'Videos',
            'paddle_product_id' => '579713',
            'requires_license' => false,
            'product_id' => $mailCoach->id,
        ]);
    }
}
