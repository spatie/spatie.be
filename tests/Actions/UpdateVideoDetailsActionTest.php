<?php

use App\Actions\UpdateVideoDetailsAction;
use App\Models\Series;
use App\Models\Video;
use App\Services\Vimeo\Vimeo;
use Tests\TestCase;



beforeEach(function () {

    $this->vimeoMock = $this->mock(Vimeo::class);
    $this->action = resolve(UpdateVideoDetailsAction::class);
});

it('updates video details', function () {
    $series = Series::create([
        'title' => 'Series',
        'slug' => 'series',
        'description' => 'Series',
    ]);

    $video = Video::withoutEvents(function () use ($series) {
        return Video::create([
            'series_id' => $series->id,
            'vimeo_id' => 1234,
            'thumbnail' => 'something',
            'title' => 'A title',
            'hash' => 'hash',
            'slug' => 'a-title',
            'sort_order' => 1,
            'runtime' => 0,
        ]);
    });

    $this->vimeoMock->shouldReceive('getVideo')->with(1234)->andReturn([
        'name' => 'A video',
        'link' => 'https://video.com/video/updated-hash',
        'description' => 'A description',
        'duration' => 123,
        'pictures' => [
            'sizes' => [
                1 => [
                    'link' => 'https://placehold.it/200x200',
                ],
            ],
        ],
    ])->once();

    $this->action->execute($video);

    tap($video->fresh(), function (Video $video) {
        expect($video->title)->toBe('A video');
        expect($video->slug)->toBe('a-video');
        expect($video->hash)->toBe('updated-hash');

        expect($video->description)->toBe('A description');
        expect($video->runtime)->toBe(123);
        expect($video->thumbnail)->toBe('https://placehold.it/200x200');
    });
});
