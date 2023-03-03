<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class ImportVideoMetaDataCommand extends Command
{
    public $signature = 'import-video-meta-data {--series=}';

    public function handle(): void
    {
        $query = Video::query();

        if ($seriesId = $this->option('series')) {
            $query->whereHas('lesson', function (Builder $query) use ($seriesId) {
                $query->where('series_id', $seriesId);
            });
        }

        $query->each(function (Video $video) {
            $video->touch();

            $this->comment("Updated `{$video->title}`");
        });

        $this->info('All done!');
    }
}
