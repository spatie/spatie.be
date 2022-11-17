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
                ->reject(fn(array $video) => $video['slug'] === $mainVideo['slug'])
                ->reject(fn(array $video) => empty($video['youtube_id'])),
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
                'youtube_id' => 'koN_Wpja6jY',
                'slug' => 'intro',
                'title' => 'Intro',
                'main' => true,
                'thumbnail' => 'https://i.ytimg.com/vi/koN_Wpja6jY/hqdefault.jpg',
            ],
            [
                'youtube_id' => 'o7r5oirbFUg',
                'slug' => 'monday-21',
                'title' => 'Monday, 21st of November',
                'main' => false,
                'thumbnail' => 'https://i.ytimg.com/vi/o7r5oirbFUg/hqdefault.jpg',
            ],
            [
                'youtube_id' => 'GU0PQTswBt8',
                'slug' => 'tuesday-22',
                'title' => 'Tuesday, 22nd of November',
                'main' => false,
                'thumbnail' => 'https://i.ytimg.com/vi/GU0PQTswBt8/hqdefault.jpg',
            ],
            [
                'youtube_id' => 'Vhonu-rM0B0',
                'slug' => 'wednesday-23',
                'title' => 'Wednesday, 23rd of November',
                'main' => false,
                'thumbnail' => 'https://i.ytimg.com/vi/Vhonu-rM0B0/hqdefault.jpg',
            ],
            [
                'youtube_id' => '',
                'slug' => 'thursday-24',
                'title' => 'Thursday, 24th of November',
                'main' => false,
                'thumbnail' => '',
            ],
            [
                'youtube_id' => '',
                'slug' => 'friday-25',
                'title' => 'Friday, 25th of November',
                'main' => false,
                'thumbnail' => '',

            ],
            [
                'youtube_id' => '',
                'slug' => 'monday-28',
                'title' => 'Monday, 28th of November',
                'main' => false,
                'thumbnail' => '',
            ],
        ]);
    }
}
