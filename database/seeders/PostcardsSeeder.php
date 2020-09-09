<?php

namespace Database\Seeders;

use Database\Seeders\DatabaseSeeder;
use App\Models\Postcard;

class PostcardsSeeder extends DatabaseSeeder
{
    public function run()
    {
        Postcard::factory()->times(3)
            ->create()
            ->each(function (Postcard $postcard) {
                $postcard
                    ->addMediaFromUrl(faker()->imageUrl(1920, 1080))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
