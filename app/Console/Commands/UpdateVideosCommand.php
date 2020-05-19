<?php

namespace App\Console\Commands;

use App\Models\Video;
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
                'sort' => $sort,
            ]);

            $currentScreencastSlugs = array_flip($seriesModel->videos->pluck('slug')->toArray());

            foreach ($series['videos'] as $screencastSort => $screencastData) {
                $screencast = $vimeoVideos->first(fn ($screencast) => $screencast['uri'] === '/videos/'.$screencastData['id']);
                $slug = Str::slug($screencast['name']);

                $this->comment("Imported Screencast: {$screencast['name']}");
                $seriesModel->videos()->updateOrCreate([
                    'vimeo_id' => $screencastData['id'],
                ], [
                    'slug' => $slug,
                    'title' => $screencast['name'],
                    'description' => $screencast['description'],
                    'sort' => $screencastSort,
                    'runtime' => $screencast['duration'],
                    'thumbnail' => $screencast['pictures']['sizes'][1]['link'],
                    'only_for_sponsors' => $screencastData['only_for_sponsors'],
                ]);

                unset($currentScreencastSlugs[$slug]);
            }

            unset($currentSeriesSlugs[$seriesModel->slug]);

            $seriesModel->videos()->whereIn('slug', array_flip($currentScreencastSlugs))->delete();
        }

        Series::whereIn('slug', array_flip($currentSeriesSlugs))->delete();

        $this->info('All done!');
    }
}
