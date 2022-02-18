<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;

class ImportVideoMetaDataCommand extends Command
{
    public $signature = 'import-video-meta-data {--series=}';

    public function handle()
    {
        $query = Video::query();

        if ($seriesId = $this->option('series')) {
            $query->where('series_id', $seriesId);
        }

        $query->each(function (Video $video) {
            $video->touch();

            $this->comment("Updated `{$video->title}`");
        });

        $this->info('All done!');
    }
}
