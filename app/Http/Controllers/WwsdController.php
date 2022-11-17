<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class WwsdController
{
    public function __invoke(string $slug = null)
    {
        $mainVideo = $this->getMainVideo($slug);

        if (! $mainVideo) {
            return redirect()->route('wwsd.index');
        }

        return view('front.pages.wwsd.index', [
            'mainVideo' => $mainVideo,
            'otherVideos' => $this->videos()
                ->reject(fn (array $video) => $video['slug'] === $mainVideo['slug'])
                ->reject(fn (array $video) => empty($video['youtube_id'])),
        ]);
    }

    protected function getMainVideo(string $slug = null): ?array
    {
        if (! $slug) {
            return $this->videos()->where('main', true)->first();
        }

        return $this->videos()->where('slug', $slug)->first();
    }

    public function videos(): Collection
    {
        return collect([
            [
                'youtube_id' => 'https://www.youtube.com/watch?v=R8z1b3f4j5I',
                'slug' => 'intro',
                'title' => 'Intro',
                'main' => true,
                'thumbnail' => 'https://i.ytimg.com/vi/R8z1b3f4j5I/hqdefault.jpg',
            ],
        ]);
    }
}
