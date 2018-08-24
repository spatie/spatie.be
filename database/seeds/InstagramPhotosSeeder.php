<?php

use App\Models\InstagramPhoto;

class InstagramPhotosSeeder extends DatabaseSeeder
{
    public function run()
    {
        factory(InstagramPhoto::class, 3)
            ->create()
            ->each(function (InstagramPhoto $photo) {
                $photo
                    ->addMediaFromUrl(faker()->imageUrl(1920, 1080))
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });
    }
}
