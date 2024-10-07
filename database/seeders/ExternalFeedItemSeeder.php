<?php

namespace Database\Seeders;

use App\Models\ExternalFeedItem;
use Illuminate\Database\Seeder;

class ExternalFeedItemSeeder extends Seeder
{
    public function run(): void
    {
        ExternalFeedItem::factory()->times(50)->create();
    }
}
