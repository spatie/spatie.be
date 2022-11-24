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
                'youtube_id' => 'Vg1vomCJgS4',
                'slug' => 'writing-readable-php',
                'title' => 'Writing Readable PHP',
                'main' => true,
                'thumbnail' => 'https://i.ytimg.com/vi/Vg1vomCJgS4/hqdefault.jpg',
            ],
            [
                'youtube_id' => 'gSnnEn5sUI8',
                'slug' => 'comments',
                'title' => 'Laravel Comments Discount',
                'main' => false,
                'thumbnail' => 'https://i.ytimg.com/vi/gSnnEn5sUI8/hqdefault.jpg',
            ],
            [
                'youtube_id' => 'JdrSqdBJZQI',
                'slug' => 'welcome',
                'title' => 'Welcome to World Wide Spatie Discounts',
                'main' => false,
                'thumbnail' => 'https://i.ytimg.com/vi/JdrSqdBJZQI/hqdefault.jpg',
            ],
            [
                'youtube_id' => 'R8z1b3f4j5I',
                'slug' => 'intro',
                'title' => 'Introducing World Wide Spatie Discounts',
                'main' => false,
                'thumbnail' => 'https://i.ytimg.com/vi/R8z1b3f4j5I/hqdefault.jpg',
            ],
        ]);
    }
}
