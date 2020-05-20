<?php

namespace App\Console\Commands;

use App\Models\Series;
use App\Services\Vimeo\Vimeo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateVideosCommand extends Command
{
    protected $signature = 'update-videos';

    protected $description = 'Update the videos with the latest from Vimeo.';

    public function handle(Vimeo $vimeo)
    {
        $this->info('Start updating videos...');

        $vimeoVideos = collect($vimeo->getVideos());

        $currentSeriesSlugs = array_flip(Series::all()->pluck('slug')->toArray());

        foreach (config('videos.series') as $sort => $series) {
            /** @var Series $seriesModel */
            $seriesModel = Series::updateOrCreate([
                'slug' => Str::slug($series['title']),
            ], [
                'title' => $series['title'],
                'description' => $series['description'],
                'sort' => $sort,
            ]);

            $currentVideoSlugs = array_flip($seriesModel->videos->pluck('slug')->toArray());

            foreach ($series['videos'] as $videoSort => $videoData) {
                $video = $vimeoVideos->first(fn ($video) => $video['uri'] === '/videos/'.$videoData['id']);
                $slug = Str::slug($video['name']);

                $this->comment("Imported Video: {$video['name']}");
                $seriesModel->videos()->updateOrCreate([
                    'vimeo_id' => $videoData['id'],
                ], [
                    'slug' => $slug,
                    'title' => $video['name'],
                    'description' => $video['description'],
                    'sort' => $videoSort,
                    'runtime' => $video['duration'],
                    'thumbnail' => $video['pictures']['sizes'][1]['link'],
                    'only_for_sponsors' => $videoData['only_for_sponsors'],
                ]);

                unset($currentVideoSlugs[$slug]);
            }

            unset($currentSeriesSlugs[$seriesModel->slug]);

            $seriesModel->videos()->whereIn('slug', array_flip($currentVideoSlugs))->delete();
        }

        Series::whereIn('slug', array_flip($currentSeriesSlugs))->delete();

        $this->info('All done!');
    }
}
