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

    public function __construct(Instagram $instagram)
    {
        parent::__construct();

        $this->instagram = $instagram;
    }

    public function handle()
    {
        $this->info('Importing instagram photos...');

        collect($this->instagram->media())
            ->map(function(stdClass $instagramProperties) {
                return new InstagramPhoto($instagramProperties);
            })
            ->filter(function(InstagramPhoto $instagramPhoto) {
                return $instagramPhoto->hasTag('larasocks');
            })
            ->each(function(InstagramPhoto $instagramPhoto) {
                InstagramPhotoModel::import($instagramPhoto);
            });

        $this->info('All done!');
    }
}
