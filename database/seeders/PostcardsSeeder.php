<?php

namespace Database\Seeders;

use App\Models\Postcard;

class PostcardsSeeder extends DatabaseSeeder
{
    public function run(): void
    {
        Postcard::factory()->times(3)
            ->create()
            ->each(function (Postcard $postcard): void {
                $postcard
                    ->addMediaFromUrl(faker()->imageUrl(1920, 1080))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
