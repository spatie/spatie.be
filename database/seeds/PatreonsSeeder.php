<?php

use Illuminate\Database\Seeder;

class PatreonsSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Models\Patreon::class, 10)
            ->create()
            ->each(function (\App\Models\Patreon $patreon) {
                $patreon
                    ->addMediaFromUrl(faker()->imageUrl(1920, 1080))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
