<?php

use App\Models\Postcard;

class PostcardsSeeder extends DatabaseSeeder
{
    public function run()
    {
        factory(Postcard::class, 3)
            ->create()
            ->each(function (Postcard $postcard) {
                $postcard
                    ->addMediaFromUrl(faker()->imageUrl(1920, 1080))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
