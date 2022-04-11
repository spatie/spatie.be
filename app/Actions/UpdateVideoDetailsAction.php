<?php

namespace App\Actions;

use App\Models\Video;
use App\Services\Vimeo\Vimeo;
use Illuminate\Support\Str;

class UpdateVideoDetailsAction
{
    private Vimeo $vimeo;

    public function __construct(Vimeo $vimeo)
    {
        $this->vimeo = $vimeo;
    }

    public function execute(Video $video): Video
    {
        $video->withoutEvents(function () use ($video) {
            $vimeoVideo = $this->vimeo->getVideo($video->vimeo_id);

            $hash = Str::afterLast($vimeoVideo['link'], '/');

            $video->update([
                'description' => $vimeoVideo['description'],
                'runtime' => $vimeoVideo['duration'],
                'thumbnail' => $vimeoVideo['pictures']['sizes'][1]['link'],
                'hash' => $hash,
            ]);


            $video->lesson?->update([
                'slug' => Str::slug($vimeoVideo['name']),
                'title' => $vimeoVideo['name'],
            ]);
        });

        return $video;
    }
}
