<?php

namespace App\Console\Commands;

use App\Services\Instagram\InstagramPhoto;
use Illuminate\Console\Command;
use stdClass;
use Vinkla\Instagram\Instagram;
use App\Models\InstagramPhoto as InstagramPhotoModel;

class ImportInstagramPhotos extends Command
{
    protected $signature = 'import:instagram-photos';

    protected $description = 'Import instagram photos';

    /** @var \Vinkla\Instagram\Instagram */
    protected $instagram;

    public function handle(Instagram $instagram)
    {
        $this->info('Importing instagram photos...');

        collect($instagram->media())
            ->map(function(stdClass $instagramProperties) {
                return new InstagramPhoto($instagramProperties);
            })
            ->filter(function(InstagramPhoto $instagramPhoto) {
                return $instagramPhoto->hasTag('laraconeu');
            })
            ->each(function(InstagramPhoto $instagramPhoto) {
                InstagramPhotoModel::import($instagramPhoto);
            });

        $this->info('All done!');
    }
}
