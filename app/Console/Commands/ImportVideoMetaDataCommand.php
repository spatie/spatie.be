<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;

class ImportVideoMetaDataCommand extends Command
{
    public $signature = 'import-video-meta-data';

    public function handle()
    {
        Video::each(function(Video $video) {
            $video->touch();

            $this->comment("Updated `{$video->title}`");
        });

        $this->info('All done!');
    }
}
