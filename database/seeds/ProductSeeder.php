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
        ]);

        $mailCoach = factory(Product::class)->create([
            'title' => 'Mailcoach',
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_STANDARD,
            'title' => 'Mailcoach single domain',
            'paddle_product_id' => '578345',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_STANDARD_RENEWAL,
            'title' => 'Mailcoach single domain renewal',
            'paddle_product_id' => '579712',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS,
            'title' => 'Mailcoach unlimited domains',
            'paddle_product_id' => '594793',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_UNLIMITED_DOMAINS_RENEWAL,
            'title' => 'Mailcoach unlimited domains renewal',
            'paddle_product_id' => '594796',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);

        factory(Purchasable::class)->create([
            'type' => PurchasableType::TYPE_VIDEOS,
            'title' => 'Only the videos',
            'paddle_product_id' => '579713',
            'requires_license' => true,
            'product_id' => $mailCoach->id,
        ]);
    }
}
