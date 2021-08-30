<?php

use App\Actions\UpdateVideoDetailsAction;
use App\Models\Series;
use App\Models\Video;
use App\Services\Vimeo\Vimeo;
use Mockery\MockInterface;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

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
            'slug' => 'a-title',
            'sort_order' => 1,
            'runtime' => 0,
        ]);
    });

    $this->vimeoMock->shouldReceive('getVideo')->with(1234)->andReturn([
        'name' => 'A video',
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
        $this->assertSame('A video', $video->title);
        $this->assertSame('a-video', $video->slug);
        $this->assertSame('A description', $video->description);
        $this->assertSame(123, $video->runtime);
        $this->assertSame('https://placehold.it/200x200', $video->thumbnail);
    });
});
