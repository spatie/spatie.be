<?php

namespace App\Console\Commands;

use App\Models\Screencast;
use App\Models\Series;
use App\Services\Vimeo\Vimeo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateScreencastsCommand extends Command
{
    protected $signature = 'update-screencasts';

    protected $description = 'Update the screencasts with the latest from Vimeo.';

    public function handle(Vimeo $vimeo)
    {
        $this->info('Start updating screencasts...');

        $vimeoVideos = collect($vimeo->getVideos());

        $currentSeriesSlugs = array_flip(Series::all()->pluck('slug')->toArray());

        foreach (config('screencasts.series') as $sort => $series) {
            /** @var Series $seriesModel */
            $seriesModel = Series::updateOrCreate([
                'slug' => Str::slug($series['title']),
            ], [
                'title' => $series['title'],
                'sort' => $sort,
            ]);

            $currentScreencastSlugs = array_flip($seriesModel->screencasts->pluck('slug')->toArray());

            foreach ($series['screencasts'] as $screencastSort => $screencastData) {
                $screencast = $vimeoVideos->first(fn ($screencast) => $screencast['uri'] === '/videos/'.$screencastData['id']);
                $slug = Str::slug($screencast['name']);

                $this->comment("Imported Screencast: {$screencast['name']}");
                $seriesModel->screencasts()->updateOrCreate([
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

            $seriesModel->screencasts()->whereIn('slug', array_flip($currentScreencastSlugs))->delete();
        }

        Series::whereIn('slug', array_flip($currentSeriesSlugs))->delete();

        $this->info('All done!');
    }
}
