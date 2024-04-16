<?php

namespace Database\Seeders;

use App\Models\Postcard;

class PostcardsSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        Postcard::factory()->times(100)
            ->create()
            ->each(function (Postcard $postcard): void {
                $postcard
                    ->addMediaFromUrl(faker()->boolean() ? faker()->imageUrl(1920, 1080) : faker()->imageUrl(1080, 1920))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
