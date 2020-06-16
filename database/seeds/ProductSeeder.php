<?php

use App\Models\License;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        factory(Product::class)->create([
            'type' => Product::TYPE_STANDARD,
            'title' => 'Mailcoach single domain',
            'paddle_product_id' => '578345',
            'price' => 99,
            'requires_license' => true,
        ]);

        factory(Product::class)->create([
            'type' => Product::TYPE_STANDARD_RENEWAL,
            'title' => 'Mailcoach single domain renewal',
            'paddle_product_id' => '579712',
            'price' => 99,
            'requires_license' => true,
        ]);

        factory(Product::class)->create([
            'type' => Product::TYPE_UNLIMITED_DOMAINS,
            'title' => 'Mailcoach unlimited domains',
            'paddle_product_id' => '594793',
            'price' => 999,
            'requires_license' => true,
        ]);

        factory(Product::class)->create([
            'type' => Product::TYPE_UNLIMITED_DOMAINS_RENEWAL,
            'title' => 'Mailcoach unlimited domains renewal',
            'paddle_product_id' => '594796',
            'price' => 999,
            'requires_license' => true,
        ]);

        factory(Product::class)->create([
            'type' => Product::TYPE_VIDEOS,
            'title' => 'Only the videos',
            'paddle_product_id' => '579713',
            'price' => 49,
            'requires_license' => true,
        ]);
    }
}
