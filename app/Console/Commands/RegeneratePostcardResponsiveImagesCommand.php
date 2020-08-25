<?php

namespace App\Console\Commands;

use App\Models\Postcard;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\ResponsiveImages\Jobs\GenerateResponsiveImagesJob;

class RegeneratePostcardResponsiveImagesCommand extends Command
{
    protected $signature = 'postcards:regenerate {--id=}';

    protected $description = 'Regenerates the responsive images for all the postcards';

    public function handle()
    {
        if ($id = $this->option('id')) {
            dispatch_now(new GenerateResponsiveImagesJob(Media::find($id)));

            return;
        }

        Postcard::each(function (Postcard $postcard) {
            $postcard->getMedia()->each(fn (Media $media) => dispatch(new GenerateResponsiveImagesJob($media)));
        });
    }
}
