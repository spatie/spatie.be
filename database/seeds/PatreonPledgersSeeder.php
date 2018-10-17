<?php

use Illuminate\Database\Seeder;

class PatreonPledgersSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Models\PatreonPledger::class, 10)
            ->create()
            ->each(function (\App\Models\PatreonPledger $patreon) {
                $patreon
                    ->addMediaFromUrl(faker()->imageUrl(1920, 1080))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
